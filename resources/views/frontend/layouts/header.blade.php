 <header class="header">
     <div class="header-top">
         <div class="container">
             <div class="header-left">
                 <div class="header-dropdown">
                     <a href="#">Usd</a>
                     <div class="header-menu">
                         <ul>

                             <li><a href="#">Usd</a></li>
                         </ul>
                     </div><!-- End .header-menu -->
                 </div><!-- End .header-dropdown -->

                 <div class="header-dropdown">
                     <a href="#">Eng</a>
                     <div class="header-menu">
                         <ul>
                             <li><a href="#">English</a></li>

                         </ul>
                     </div><!-- End .header-menu -->
                 </div><!-- End .header-dropdown -->
             </div><!-- End .header-left -->

             <div class="header-right">
                 <ul class="top-menu">
                     <li>
                         <a href="#">Links</a>
                         <ul>
                             <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                             <li><a href="{{ asset('wishlist.html') }}"><i class="icon-heart-o"></i>My Wishlist
                                     <span>(3)</span></a></li>
                             <li><a href="{{ asset('about.html') }}">About Us</a></li>
                             <li><a href="{{ asset('contact.html') }}">Contact Us</a></li>
                             <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a>
                             </li>
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
                     <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="Molla Logo" width="105"
                         height="25">
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
        aria-haspopup="true" aria-expanded="false" data-display="static">
        <i class="icon-shopping-cart"></i>
        <span class="cart-count" id="header-cart-count">{{ Cart::getTotalQuantity() }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" id="cart-dropdown-menu">
        @if (Cart::isEmpty())
            <p class="text-center p-3">Your cart is empty</p>
        @else
            <div class="dropdown-cart-products" id="dropdown-cart-products">
                @foreach (Cart::getContent() as $item)
                    <div class="product" id="dropdown-item-{{ $item->id }}">
                        <div class="product-cart-details">
                            <h4 class="product-title">
                                <a href="">
                                    {{ $item->name }}
                                </a>
                            </h4>

                            <span class="cart-product-info">
                                <span class="cart-product-qty">{{ $item->quantity }}</span>
                                x ${{ number_format($item->price, 2) }}
                            </span>
                        </div><!-- End .product-cart-details -->

                        <figure class="product-image-container">
                            <a href="" class="product-image">
                                <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}">
                            </a>
                        </figure>

                        <a href="#" class="btn-remove remove-item-dropdown"
                           data-rowid="{{ $item->id }}" title="Remove Product">
                            <i class="icon-close"></i>
                        </a>
                    </div><!-- End .product -->
                @endforeach
            </div><!-- End .dropdown-cart-products -->

            <div class="dropdown-cart-total">
                <span>Total</span>
                <span class="cart-total-price" id="dropdown-cart-total">${{ number_format(Cart::getTotal(), 2) }}</span>
            </div><!-- End .dropdown-cart-total -->

            <div class="dropdown-cart-action">
                <a href="{{ route('cart.index') }}" class="btn btn-primary">View Cart</a>
                <a href="" class="btn btn-outline-primary-2">
                    <span>Checkout</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div><!-- End .dropdown-cart-action -->
        @endif
    </div><!-- End .dropdown-menu -->
</div>
             </div><!-- End .container -->
         </div><!-- End .header-middle -->
 </header><!-- End .header -->
