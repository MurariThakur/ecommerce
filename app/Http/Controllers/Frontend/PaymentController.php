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
            return back()->with('error', 'Please select a size.');
        }
        if ($product->colors->count() > 0 && !$request->color) {
            return back()->with('error', 'Please select a color.');
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

            return back()->with('success', 'Product quantity updated in cart!');
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

        return back()->with('success', 'Product added to cart successfully!');
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

    public function getCartDropdown()
    {
        $cartContent = Cart::getContent();
        $total = Cart::getTotal();
        $itemsCount = Cart::getTotalQuantity();

        if ($cartContent->isEmpty()) {
            return '<p class="text-center p-3">Your cart is empty</p>';
        }

        $html = '<div class="dropdown-cart-products">';

        foreach ($cartContent as $item) {
            $html .= '
        <div class="product" id="dropdown-item-' . $item->id . '">
            <div class="product-cart-details">
                <h4 class="product-title">
                    <a href=" ">
                        ' . e($item->name) . '
                    </a>
                </h4>
                <span class="cart-product-info">
                    <span class="cart-product-qty">' . $item->quantity . '</span>
                    x $' . number_format($item->price, 2) . '
                </span>
            </div>
            <figure class="product-image-container">
                <a href="" class="product-image">
                    <img src="' . e($item->attributes->image) . '" alt="' . e($item->name) . '">
                </a>
            </figure>
            <a href="#" class="btn-remove remove-item-dropdown"
               data-rowid="' . $item->id . '" title="Remove Product">
                <i class="icon-close"></i>
            </a>
        </div>';
        }

        $html .= '</div>
    <div class="dropdown-cart-total">
        <span>Total</span>
        <span class="cart-total-price">$' . number_format($total, 2) . '</span>
    </div>
    <div class="dropdown-cart-action">
        <a href="' . route('cart.index') . '" class="btn btn-primary">View Cart</a>
        <a href="" class="btn btn-outline-primary-2">
            <span>Checkout</span>
            <i class="icon-long-arrow-right"></i>
        </a>
    </div>';

        return $html;
    }

}
