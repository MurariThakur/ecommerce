<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the frontend home page
     */
    public function index()
    {
        // Set default meta data for home page
        $meta_title = 'Ecommerce - Home';
        $meta_description = 'Welcome to our ecommerce store. Find the best products at great prices.';
        $meta_keyword = 'ecommerce, online shopping, products';

        // Get active sliders
        $sliders = Slider::where('status', true)->orderBy('created_at', 'desc')->get();

        // Get active partners
        $partners = Partner::where('status', true)->orderBy('created_at', 'desc')->get();

        // Get categories for home page
        $homeCategories = Category::where('status', true)
            ->where('isdelete', false)
            ->where('is_home', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get categories for Recent Arrivals navigation
        $navCategories = Category::where('status', true)
            ->where('isdelete', false)
            ->orderBy('name')
            ->limit(4)
            ->get();

        // Get recent products for all categories
        $allProducts = Product::with(['category', 'subcategory', 'productImages'])
            ->where('status', true)
            ->where('isdelete', false)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get recent products by category
        $categoryProducts = [];
        foreach ($navCategories as $category) {
            $categoryProducts[$category->slug] = Product::with(['category', 'subcategory', 'productImages'])
                ->where('status', true)
                ->where('isdelete', false)
                ->where('category_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        }

        // Get trendy products
        $trendyProducts = Product::with(['category', 'subcategory', 'productImages'])
            ->where('status', true)
            ->where('isdelete', false)
            ->where('is_trendy', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('frontend.home', compact('meta_title', 'meta_description', 'meta_keyword', 'sliders', 'partners', 'homeCategories', 'navCategories', 'allProducts', 'categoryProducts', 'trendyProducts'));
    }


    public function contact()
    {
        // Set default meta data for contact page
        $meta_title = 'Contact Us - Ecommerce';
        $meta_description = 'Get in touch with our support team for any inquiries or assistance.';
        $meta_keyword = 'contact, support, help, ecommerce';

        return view('frontend.pages.contact', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function about()
    {
        $meta_title = 'About Us - Ecommerce';
        $meta_description = 'Learn more about our ecommerce store, our mission, and our values.';
        $meta_keyword = 'about us, ecommerce, company, mission';

        return view('frontend.pages.about', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function faq()
    {
        $meta_title = 'FAQ - Ecommerce';
        $meta_description = 'Find answers to frequently asked questions about our products and services.';
        $meta_keyword = 'faq, questions, help, support';

        return view('frontend.pages.faq', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function paymentMethods()
    {
        $meta_title = 'Payment Methods - Ecommerce';
        $meta_description = 'Learn about our secure payment options including credit cards, PayPal, and cash on delivery.';
        $meta_keyword = 'payment, credit card, paypal, secure';

        return view('frontend.pages.payment-methods', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function returns()
    {
        $meta_title = 'Returns & Exchanges - Ecommerce';
        $meta_description = 'Easy returns and exchanges with our 30-day return policy.';
        $meta_keyword = 'returns, exchanges, refund, policy';

        return view('frontend.pages.returns', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function shipping()
    {
        $meta_title = 'Shipping Information - Ecommerce';
        $meta_description = 'Fast and reliable shipping options with tracking information.';
        $meta_keyword = 'shipping, delivery, tracking, fast';

        return view('frontend.pages.shipping', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function terms()
    {
        $meta_title = 'Terms & Conditions - Ecommerce';
        $meta_description = 'Read our terms and conditions for using our ecommerce platform.';
        $meta_keyword = 'terms, conditions, legal, agreement';

        return view('frontend.pages.terms', compact('meta_title', 'meta_description', 'meta_keyword'));
    }

    public function privacy()
    {
        $meta_title = 'Privacy Policy - Ecommerce';
        $meta_description = 'Learn how we protect your privacy and handle your personal information.';
        $meta_keyword = 'privacy, policy, data, protection';

        return view('frontend.pages.privacy', compact('meta_title', 'meta_description', 'meta_keyword'));
    }
}
