<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        
        return view('frontend.home', compact('meta_title', 'meta_description', 'meta_keyword'));
    }
}
