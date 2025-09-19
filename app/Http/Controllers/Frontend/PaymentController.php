<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    /**
     * Add to Cart with variant support
     */
    public function checkCart(Request $request)
    {
        $productId = $request->product_id;
        $color = $request->color ?? 'no-color';
        $size = $request->size ?? 'no-size';

        // Generate the same row ID that would be used in addToCart
        $variantKey = $productId . '|' . $size . '|' . $color;
        $rowId = md5($variantKey);

        $item = Cart::get($rowId);

        return response()->json([
            'in_cart' => !is_null($item),
            'quantity' => $item ? $item->quantity : 0,
            'row_id' => $rowId
        ]);
    }

    /**
     * Add to Cart with variant support
     */
    public function addToCart(Request $request)
    {
        $product = Product::with(['productSizes', 'colors', 'productImages', 'category', 'subcategory'])->findOrFail($request->product_id);

        // Validate options
        if ($product->productSizes->count() > 0 && !$request->size) {
            $message = 'Please select a size.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
        if ($product->colors->count() > 0 && !$request->color) {
            $message = 'Please select a color.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }

        // Base price + size adjustment
        $price = $product->price;
        $sizeAdditionalPrice = 0;
        if ($request->size) {
            $size = $product->productSizes->where('size_name', $request->size)->first();
            if ($size) {
                $sizeAdditionalPrice = $size->additional_price;
                $price += $sizeAdditionalPrice;
            }
        }

        // Generate unique row ID based on product ID, size, and color
        $variantKey = $product->id . '|' . ($request->size ?? 'no-size') . '|' . ($request->color ?? 'no-color');
        $rowId = md5($variantKey);

        // Check if this exact variant already exists in cart
        $existingItem = Cart::get($rowId);
        $quantity = $request->qty ?? 1;

        // If item exists, update quantity instead of adding duplicate
        if ($existingItem) {
            Cart::update($rowId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $existingItem->quantity + $quantity
                ]
            ]);

            $message = 'Product quantity updated in cart!';
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'itemsCount' => Cart::getTotalQuantity(),
                    'cartTotal' => number_format(Cart::getTotal(), 2),
                    'action' => 'updated'
                ]);
            }
            return back()->with('success', $message);
        }

        // Product image from storage
        $image = null;
        if ($product->productImages->count() > 0) {
            $productImage = $product->productImages->first();
            $image = asset('storage/' . $productImage->image_path);
        }

        // Product URL
        $productUrl = route('product.details', [
            'category_slug' => $product->category->slug,
            'subcategory_slug' => $product->subcategory->slug,
            'product_slug' => $product->slug
        ]);

        // Add new item to cart
        Cart::add([
            'id' => $rowId, // unique id based on variant
            'name' => $product->title,
            'price' => $price,
            'quantity' => $quantity,
            'attributes' => [
                'product_id' => $product->id,
                'size' => $request->size ?? null,
                'color' => $request->color ?? null,
                'image' => $image,
                'base_price' => $product->price,
                'size_additional_price' => $sizeAdditionalPrice,
                'variant_key' => $variantKey,
                'url' => $productUrl,
            ],
        ]);

        $message = 'Product added to cart successfully!';
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'itemsCount' => Cart::getTotalQuantity(),
                'cartTotal' => number_format(Cart::getTotal(), 2),
                'action' => 'added'
            ]);
        }
        return back()->with('success', $message);
    }

    /**
     * Show Cart
     */
    public function cart()
    {
        $cartItems = Cart::getContent();
        return view('frontend.cart', compact('cartItems'));
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $quantity = $request->quantity;

        // Validate quantity
        if ($quantity < 1 || $quantity > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity must be between 1 and 10'
            ]);
        }

        // Update cart
        Cart::update($rowId, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity
            ]
        ]);

        $item = Cart::get($rowId);

        return response()->json([
            'success' => true,
            'itemTotal' => number_format($item->price * $item->quantity, 2),
            'subTotal' => number_format(Cart::getSubTotal(), 2),
            'total' => number_format(Cart::getTotal(), 2),
            'itemsCount' => Cart::getTotalQuantity() // Add this
        ]);
    }

    /**
     * Remove item from cart via AJAX
     */
    public function removeFromCart(Request $request)
    {
        $rowId = $request->rowId;

        Cart::remove($rowId);

        return response()->json([
            'success' => true,
            'subTotal' => number_format(Cart::getSubTotal(), 2),
            'total' => number_format(Cart::getTotal(), 2),
            'itemsCount' => Cart::getTotalQuantity() // This already exists
        ]);
    }

    /**
     * Clear cart via AJAX
     */
    public function clearCart(Request $request)
    {
        Cart::clear();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartContent = Cart::getContent();

        // Redirect to cart if empty
        if ($cartContent->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subTotal = Cart::getSubTotal();
        $freeShippingSetting = \App\Models\Setting::where('key', 'free_shipping_threshold')->first();
        $freeShippingThreshold = $freeShippingSetting ? (float) $freeShippingSetting->value : 0;
        $freeShippingEnabled = $freeShippingSetting ? $freeShippingSetting->status : false;

        // Check if eligible for free shipping
        $isFreeShipping = $freeShippingEnabled && $subTotal >= $freeShippingThreshold && $freeShippingThreshold > 0;

        if ($isFreeShipping) {
            $shippingMethods = collect();
            $total = Cart::getTotal();
        } else {
            $shippingMethods = \App\Models\Shipping::where('status', true)->where('is_deleted', false)->get();
            $firstShippingCost = $shippingMethods->first() ? $shippingMethods->first()->price : 0;
            $total = Cart::getTotal() + $firstShippingCost;
        }

        return view('frontend.payment.checkout', compact('cartContent', 'subTotal', 'total', 'shippingMethods', 'isFreeShipping', 'freeShippingThreshold', 'freeShippingEnabled'));
    }

    /**
     * Get checkout summary data for AJAX updates
     */
    public function getCheckoutSummary()
    {
        $cartContent = Cart::getContent();

        if ($cartContent->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ]);
        }

        $cartItems = [];
        foreach ($cartContent as $item) {
            $cartItems[] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity,
                'color' => $item->attributes->color ?? null,
                'size' => $item->attributes->size ?? null,
                'url' => $item->attributes->url ?? '#'
            ];
        }

        $subTotal = Cart::getSubTotal();
        $freeShippingSetting = \App\Models\Setting::where('key', 'free_shipping_threshold')->first();
        $freeShippingThreshold = $freeShippingSetting ? (float) $freeShippingSetting->value : 0;
        $freeShippingEnabled = $freeShippingSetting ? $freeShippingSetting->status : false;
        $isFreeShipping = $freeShippingEnabled && $subTotal >= $freeShippingThreshold && $freeShippingThreshold > 0;

        $shippingMethods = [];
        if (!$isFreeShipping) {
            $methods = \App\Models\Shipping::where('status', true)->where('is_deleted', false)->get();
            foreach ($methods as $method) {
                $shippingMethods[] = [
                    'id' => $method->id,
                    'name' => $method->name,
                    'price' => $method->price
                ];
            }
        }

        return response()->json([
            'success' => true,
            'cartItems' => $cartItems,
            'subTotal' => Cart::getSubTotal(),
            'total' => Cart::getTotal(),
            'itemsCount' => Cart::getTotalQuantity(),
            'isFreeShipping' => $isFreeShipping,
            'shippingMethods' => $shippingMethods,
            'freeShippingThreshold' => $freeShippingThreshold,
            'freeShippingEnabled' => $freeShippingEnabled
        ]);
    }

    public function getCartDropdown()
    {
        return view('frontend.layouts.cart_dropdown')->render();
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string'
        ]);

        $discountCode = $request->discount_code;
        $cartSubTotal = Cart::getSubTotal();

        // Find active discount
        $discount = \App\Models\Discount::where('name', $discountCode)
            ->where('status', true)
            ->whereDate('expire_date', '>=', now())
            ->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired discount code'
            ]);
        }

        // Check minimum order amount
        if ($discount->min_order_amount && $cartSubTotal < $discount->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount of $' . number_format($discount->min_order_amount, 2) . ' required'
            ]);
        }

        // Check usage limit
        if ($discount->usage_limit && $discount->used_count >= $discount->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Discount code usage limit exceeded'
            ]);
        }

        // Calculate discount amount
        $discountAmount = 0;
        if ($discount->type === 'percentage') {
            $discountAmount = ($cartSubTotal * $discount->value) / 100;
            // Apply max discount limit if set
            if ($discount->max_discount_amount && $discountAmount > $discount->max_discount_amount) {
                $discountAmount = $discount->max_discount_amount;
            }
        } else {
            $discountAmount = $discount->value;
        }

        // Ensure discount doesn't exceed cart total
        if ($discountAmount > $cartSubTotal) {
            $discountAmount = $cartSubTotal;
        }

        $newTotal = $cartSubTotal - $discountAmount;

        // Store discount in session
        session([
            'applied_discount' => [
                'id' => $discount->id,
                'name' => $discount->name,
                'type' => $discount->type,
                'value' => $discount->value,
                'amount' => $discountAmount
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discount applied successfully',
            'discount_amount' => number_format($discountAmount, 2),
            'new_total' => number_format($newTotal, 2),
            'discount_name' => $discount->name
        ]);
    }

    public function removeDiscount()
    {
        session()->forget('applied_discount');

        return response()->json([
            'success' => true,
            'message' => 'Discount removed',
            'new_total' => number_format(Cart::getTotal(), 2)
        ]);
    }

    /**
     * Place order function
     */
    public function placeOrder(Request $request)
    {
        $cartContent = Cart::getContent();

        if ($cartContent->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Create account if requested (before order creation)
        $userId = auth()->id();
        if ($request->password && !auth()->check()) {
            // Check if email already exists
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'email_exists' => true,
                        'message' => 'Email already registered. Please use a different email or login to your account.'
                    ]);
                }
                return back()->withErrors(['email' => 'Email already registered']);
            }

            try {
                $user = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);

                // Login the user
                auth()->login($user);
                $userId = $user->id;
            } catch (\Exception $e) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error creating account. Please try again.'
                    ]);
                }
                return back()->withErrors(['email' => 'Error creating account']);
            }
        }

        // Calculate totals
        $subtotal = Cart::getSubTotal();
        $shippingCost = $request->shipping_cost ?? 0;
        $discountAmount = $request->discount_amount ?? 0;
        $total = $subtotal + $shippingCost - $discountAmount;

        // Create order with pending status and expiration
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'user_id' => $userId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'country' => $request->country,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'notes' => $request->notes,
            'discount_id' => $request->discount_id,
            'discount_name' => $request->discount_name,
            'discount_amount' => $discountAmount,
            'shipping_method' => $request->shipping_method,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(1),
        ]);

        // Create order items
        foreach ($cartContent as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->attributes->product_id,
                'color' => $item->attributes->color,
                'size' => $item->attributes->size,
                'price' => $item->price,
                'size_additional_price' => $item->attributes->size_additional_price ?? 0,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity,
            ]);
        }



        // Process payment directly based on method
        switch ($order->payment_method) {
            case 'cash':
                return $this->processCashPayment($order, $request);
            case 'paypal':
                return $this->processPaypalPayment($order, $request);
            case 'stripe':
                return $this->processStripePayment($order, $request);
            default:
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Invalid payment method']);
                }
                return redirect()->route('cart.index')->with('error', 'Invalid payment method');
        }
    }

    /**
     * Process cash on delivery payment
     */
    private function processCashPayment($order, $request)
    {
        $order->update([
            'status' => 'confirmed',
            'is_payment' => false,
            'expires_at' => null,
            'payment_data' => ['method' => 'cash_on_delivery']
        ]);

        return $this->completeOrder($order, $request);
    }

    /**
     * Process PayPal payment
     */
    private function processPaypalPayment($order, $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success', $order->id),
                    "cancel_url" => route('paypal.cancel', $order->id),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($order->total, 2, '.', '')
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        session(['paypal_order_id' => $order->id]);

                        if ($request->ajax()) {
                            return response()->json([
                                'success' => true,
                                'redirect' => $links['href']
                            ]);
                        }
                        return redirect()->away($links['href']);
                    }
                }
            }

            $order->delete();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'PayPal payment failed']);
            }
            return redirect()->route('cart.index')->with('error', 'PayPal payment failed');

        } catch (\Exception $e) {
            $order->delete();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'PayPal error: ' . $e->getMessage()]);
            }
            return redirect()->route('cart.index')->with('error', 'PayPal error: ' . $e->getMessage());
        }
    }

    /**
     * Process Stripe payment
     */
    private function processStripePayment($order, $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret', env('STRIPE_SECRET')));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->order_number,
                            ],
                            'unit_amount' => $order->total * 100, // Convert to cents
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success', $order->id),
                'cancel_url' => route('stripe.cancel', $order->id),
                'metadata' => [
                    'order_id' => $order->id
                ]
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $session->url
                ]);
            }
            return redirect($session->url);

        } catch (\Exception $e) {
            $order->delete();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Stripe error: ' . $e->getMessage()]);
            }
            return redirect()->route('cart.index')->with('error', 'Stripe error: ' . $e->getMessage());
        }
    }

    /**
     * PayPal success callback
     */
    public function paypalSuccess($orderId)
    {

        try {
            $order = Order::findOrFail($orderId);

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder(request('token'));
            dd($response);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $order->update([
                    'status' => 'confirmed',
                    'is_payment' => true,
                    'expires_at' => null,
                    'payment_data' => [
                        'method' => 'paypal',
                        'transaction_id' => $response['id'],
                        'status' => 'completed',
                        'payer_id' => $response['payer']['payer_id'] ?? null,
                        'payment_status' => $response['status']
                    ]
                ]);

                return $this->completeOrder($order);
            }

            $order->delete();
            return redirect()->route('cart.index')->with('error', 'Payment verification failed');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Payment error: ' . $e->getMessage());
        }
    }

    /**
     * PayPal cancel callback
     */
    public function paypalCancel($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->delete(); // Remove cancelled order
        }
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled');
    }

    /**
     * Stripe success callback
     */
    public function stripeSuccess($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            $order->update([
                'status' => 'confirmed',
                'is_payment' => true,
                'expires_at' => null,
                'payment_data' => [
                    'method' => 'stripe',
                    'transaction_id' => request('session_id') ?? 'ST_' . time(),
                    'status' => 'completed'
                ]
            ]);

            return $this->completeOrder($order);

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Payment error: ' . $e->getMessage());
        }
    }

    /**
     * Stripe cancel callback
     */
    public function stripeCancel($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->delete(); // Remove cancelled order
        }
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled');
    }

    /**
     * Complete order and redirect to success
     */
    private function completeOrder($order, $request = null)
    {
        // Clear cart and sessions
        // Cart::clear();
        session()->forget('applied_discount');

        if ($request && $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully! Order number: ' . $order->order_number,
                'redirect' => route('cart.index') . '?success=' . urlencode('Order placed successfully! Order number: ' . $order->order_number)
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Order placed successfully! Order number: ' . $order->order_number);
    }

}
