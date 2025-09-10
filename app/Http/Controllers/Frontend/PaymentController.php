<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;

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
        $product = Product::with(['productSizes', 'colors', 'productImages'])->findOrFail($request->product_id);

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
        $total = Cart::getTotal();

        return view('frontend.payment.checkout', compact('cartContent', 'subTotal', 'total'));
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
                'size' => $item->attributes->size ?? null
            ];
        }

        return response()->json([
            'success' => true,
            'cartItems' => $cartItems,
            'subTotal' => Cart::getSubTotal(),
            'total' => Cart::getTotal(),
            'itemsCount' => Cart::getTotalQuantity()
        ]);
    }

    public function getCartDropdown()
    {
        return view('frontend.layouts.cart_dropdown')->render();
    }

}
