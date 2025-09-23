<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.home');
        }

        $wishlists = Wishlist::with('product.productImages', 'product.category', 'product.subcategory')
            ->where('user_id', Auth::id())
            ->paginate(12);

        return view('frontend.wishlist', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to wishlist'
            ]);
        }

        $productId = $request->product_id;
        $userId = Auth::id();

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        // If this is just a check request, return current status
        if ($request->check_only) {
            return response()->json([
                'success' => true,
                'in_wishlist' => (bool) $wishlist
            ]);
        }

        if ($wishlist) {
            $wishlist->delete();
            $inWishlist = false;
            $message = 'Product removed from wishlist';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $inWishlist = true;
            $message = 'Product added to wishlist';
        }

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $message,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $wishlistCount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist'
        ]);
    }

    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
