<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // Get recent blogs for home page
        $homeBlogs = Blog::with('blogCategory')
            ->where('status', true)
            ->where('isdelete', false)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('frontend.home', compact('meta_title', 'meta_description', 'meta_keyword', 'sliders', 'partners', 'homeCategories', 'navCategories', 'allProducts', 'categoryProducts', 'trendyProducts', 'homeBlogs'));
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

    public function blog(Request $request)
    {
        $meta_title = 'Blog - Ecommerce';
        $meta_description = 'Read our latest blog posts and stay updated with industry news and insights.';
        $meta_keyword = 'blog, news, articles, insights';

        $query = Blog::with('blogCategory')
            ->where('status', true)
            ->where('isdelete', false);

        // Search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = BlogCategory::where('status', true)
            ->where('isdelete', false)
            ->withCount([
                'blogs' => function ($q) {
                    $q->where('status', true)->where('isdelete', false);
                }
            ])
            ->orderBy('name')
            ->get();

        $recentBlogs = Blog::where('status', true)
            ->where('isdelete', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.pages.blog', compact('meta_title', 'meta_description', 'meta_keyword', 'blogs', 'categories', 'recentBlogs'));
    }

    public function blogDetail($slug)
    {
        $blog = Blog::with(['blogCategory', 'comments.user'])
            ->where('slug', $slug)
            ->where('status', true)
            ->where('isdelete', false)
            ->firstOrFail();

        $meta_title = $blog->meta_title ?: $blog->title . ' - Blog';
        $meta_description = $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160);
        $meta_keyword = $blog->meta_keyword ?: 'blog, article';

        $recentBlogs = Blog::where('status', true)
            ->where('isdelete', false)
            ->where('id', '!=', $blog->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $relatedBlogs = Blog::where('status', true)
            ->where('isdelete', false)
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $categories = BlogCategory::where('status', true)
            ->where('isdelete', false)
            ->withCount([
                'blogs' => function ($q) {
                    $q->where('status', true)->where('isdelete', false);
                }
            ])
            ->orderBy('name')
            ->get();

        return view('frontend.pages.blog-detail', compact('meta_title', 'meta_description', 'meta_keyword', 'blog', 'recentBlogs', 'categories', 'relatedBlogs'));
    }

    public function storeComment(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = BlogComment::create([
            'blog_id' => $blog->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        Notification::createNotification(
            'comment',
            'New Blog Comment',
            'New comment on blog "' . $blog->title . '" by ' . auth()->user()->name,
            route('frontend.blog.detail', $blog->slug),
            null,
            'fas fa-comment',
            'info'
        );

        return redirect()->route('frontend.blog.detail', $slug)->with('success', 'Comment posted successfully!');
    }
}

