 <header class="header">
     <div class="header-top">
         <div class="container">
             <div class="header-left">
                 
             </div><!-- End .header-left -->

             <div class="header-right mt-1">
                 <ul class="top-menu">
                     <li>
                         <a href="#">Links</a>
                         <ul>
                             <li><a href="tel:{{ \App\Models\Setting::where('key', 'mobile')->value('value') ?? '#' }}"><i
                                         class="icon-phone"></i>Call:
                                     {{ \App\Models\Setting::where('key', 'mobile')->value('value') ?? '+0123 456 789' }}</a>
                             </li>
                             <li><a href="{{ auth()->check() ? route('wishlist.index') : '#signin-modal' }}"
                                     {{ !auth()->check() ? 'data-toggle=modal' : '' }}><i class="icon-heart-o"
                                         id="header-wishlist-icon"></i>My Wishlist
                                     <span
                                         id="wishlist-count">({{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }})</span></a>
                             </li>
                             <li><a href="{{ route('about') }}">About Us</a></li>
                             <li><a href="{{ route('contact') }}">Contact Us</a></li>
                             @auth
                                 <li><a href="{{ route('user.dashboard') }}"><i class="icon-user"></i>Dashboard</a></li>
                             @else
                                 <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                             @endauth
                         </ul>
                     </li>
                 </ul><!-- End .top-menu -->
             </div><!-- End .header-right -->
         </div><!-- End .container -->
     </div><!-- End .header-top -->
     <div class="header-middle sticky-header">
         <div class="container">
             <div class="header-left">
                 <button class="mobile-menu-toggler">
                     <span class="sr-only">Toggle mobile menu</span>
                     <i class="icon-bars"></i>
                 </button>

                 <a href="{{ url('') }}" class="logo">
                     <img src="{{ \App\Models\Setting::where('key', 'website_logo')->value('value') ? asset('storage/' . \App\Models\Setting::where('key', 'website_logo')->value('value')) : asset('frontend/assets/images/logo.png') }}"
                         alt="{{ \App\Models\Setting::where('key', 'website_name')->value('value') ?? 'Ecommerce' }}"
                         width="105" height="25">
                 </a>

                 <nav class="main-nav">
                     <ul class="menu sf-arrows">
                         <li class="active">
                             <a href="{{ url('/') }}">Home</a>
                         </li>
                         <li>
                             <a href="#" class="sf-with-ul">Shop</a>

                             @php
                                 $categories = App\Models\Category::getMenuCategories();
                             @endphp

                             @if ($categories->count() > 0)
                                 <div class="megamenu megamenu-md">
                                     <div class="row no-gutters">
                                         <div class="col-md-12">
                                             <div class="menu-col">
                                                 <div class="row">
                                                     @foreach ($categories as $category)
                                                         <div class="col-md-4" style="margin-bottom: 20px;">
                                                             <a href="{{ url($category->slug) }}"
                                                                 class="menu-title">{{ $category->name }}</a>
                                                             <!-- End .menu-title -->
                                                             @if ($category->activeSubcategories->count() > 0)
                                                                 <ul>
                                                                     @foreach ($category->activeSubcategories as $subcategory)
                                                                         <li><a
                                                                                 href="{{ url($category->slug . '/' . $subcategory->slug) }}">{{ $subcategory->name }}</a>
                                                                         </li>
                                                                     @endforeach
                                                                 </ul>
                                                             @else
                                                                 <ul>
                                                                     <li><a href="{{ url($category->slug) }}">View All
                                                                             {{ $category->name }}</a></li>
                                                                 </ul>
                                                             @endif
                                                         </div><!-- End .col-md-4 -->
                                                     @endforeach
                                                 </div><!-- End .row -->
                                             </div><!-- End .menu-col -->
                                         </div><!-- End .col-md-12 -->
                                     </div><!-- End .row -->
                                 </div><!-- End .megamenu megamenu-md -->
                             @else
                                 <div class="megamenu megamenu-md">
                                     <div class="row no-gutters">
                                         <div class="col-md-12">
                                             <div class="menu-col">
                                                 <div class="row">
                                                     <div class="col-md-12 text-center" style="padding: 20px;">
                                                         <p>No categories available</p>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endif
                         </li>


                     </ul><!-- End .menu -->
                 </nav><!-- End .main-nav -->
             </div><!-- End .header-left -->

             <div class="header-right">
                 <div class="header-search">
                     <a href="#" class="search-toggle" role="button" title="Search"><i
                             class="icon-search"></i></a>
                     <form action="{{ route('frontend.search') }}" method="get">
                         <div class="header-search-wrapper">
                             <label for="q" class="sr-only">Search</label>
                             <input type="search" class="form-control" name="q" id="q"
                                 placeholder="Search products..." value="{{ request('q') }}" required>
                         </div><!-- End .header-search-wrapper -->
                     </form>
                 </div><!-- End .header-search -->

                 <div class="dropdown cart-dropdown" id="cart-dropdown">
                     <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="false" data-display="static" style="position: relative;">
                         <i class="icon-shopping-cart"></i>
                         <span class="cart-count" id="header-cart-count"
                             style="position: absolute; top: -8px; right: -8px; background: #ff6b6b; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; font-weight: bold; display: flex; align-items: center; justify-content: center; min-width: 18px;">{{ Cart::getTotalQuantity() }}</span>
                     </a>

                     <div class="dropdown-menu dropdown-menu-right" id="cart-dropdown-menu">
                         @include('frontend.layouts.cart_dropdown')
                     </div><!-- End .dropdown-menu -->
                 </div>
             </div><!-- End .container -->
         </div><!-- End .header-middle -->
 </header><!-- End .header -->
