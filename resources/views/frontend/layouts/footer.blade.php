<footer class="footer footer-dark">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="widget widget-about">
                        <img src="{{ \App\Models\Setting::where('key', 'website_logo')->value('value') ? asset('storage/' . \App\Models\Setting::where('key', 'website_logo')->value('value')) : asset('frontend/assets/images/logo-footer.png') }}"
                            class="footer-logo"
                            alt="{{ \App\Models\Setting::where('key', 'website_name')->value('value') ?? 'Footer Logo' }}"
                            width="105" height="25">
                        <p>{{ \App\Models\Setting::where('key', 'footer_description')->value('value') ?? 'Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat.' }}
                        </p>

                        <div class="social-icons">
                            @if (\App\Models\Setting::where('key', 'facebook_link')->value('value'))
                                <a href="{{ \App\Models\Setting::where('key', 'facebook_link')->value('value') }}"
                                    class="social-icon" title="Facebook" target="_blank"><i
                                        class="icon-facebook-f"></i></a>
                            @endif
                            @if (\App\Models\Setting::where('key', 'twitter_link')->value('value'))
                                <a href="{{ \App\Models\Setting::where('key', 'twitter_link')->value('value') }}"
                                    class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            @endif
                            @if (\App\Models\Setting::where('key', 'instagram_link')->value('value'))
                                <a href="{{ \App\Models\Setting::where('key', 'instagram_link')->value('value') }}"
                                    class="social-icon" title="Instagram" target="_blank"><i
                                        class="icon-instagram"></i></a>
                            @endif
                            @if (\App\Models\Setting::where('key', 'youtube_link')->value('value'))
                                <a href="{{ \App\Models\Setting::where('key', 'youtube_link')->value('value') }}"
                                    class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            @endif
                            @if (\App\Models\Setting::where('key', 'pinterest_link')->value('value'))
                                <a href="{{ \App\Models\Setting::where('key', 'pinterest_link')->value('value') }}"
                                    class="social-icon" title="Pinterest" target="_blank"><i
                                        class="icon-pinterest"></i></a>
                            @endif
                        </div><!-- End .soial-icons -->
                    </div><!-- End .widget about-widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('frontend.blog') }}">Blog</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('contact') }}">Contact us</a></li>
                            <li><a href="#signin-modal" data-toggle="modal">Log in</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a href="{{ route('payment.methods') }}">Payment Methods</a></li>
                            <li><a href="{{ route('returns') }}">Money-back guarantee!</a></li>
                            <li><a href="{{ route('returns') }}">Returns</a></li>
                            <li><a href="{{ route('shipping') }}">Shipping</a></li>
                            <li><a href="{{ route('terms') }}">Terms and conditions</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a href="#signin-modal" data-toggle="modal">Sign In</a></li>
                            <li><a href="{{ route('cart.index') }}">View Cart</a></li>
                            <li><a href="{{ route('wishlist.index') }}">My Wishlist</a></li>
                            <li><a href="{{ auth()->check() ? route('user.orders') : '#signin-modal' }}"
                                    {{ !auth()->check() ? 'data-toggle=modal' : '' }}>Track My Order</a></li>
                            <li><a href="{{ route('contact') }}">Help</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p>
            <!-- End .footer-copyright -->
            <figure class="footer-payments">
                <img src="{{ \App\Models\Setting::where('key', 'footer_payment_icon')->value('value') ? asset('storage/' . \App\Models\Setting::where('key', 'footer_payment_icon')->value('value')) : asset('frontend/assets/images/payments.png') }}"
                    alt="Payment methods" width="272" height="20">
            </figure><!-- End .footer-payments -->
        </div><!-- End .container -->
    </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
