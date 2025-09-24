@extends('frontend.layouts.app')
@section('title', 'Contact Us')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Contact us 2<span>Pages</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us 2</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div id="map" class="mb-5"></div><!-- End #map -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Office</h3>

                            <address>
                                {{ \App\Models\Setting::where('key', 'office_address')->value('value') ?? '1 New York Plaza, New York, NY 10004, USA' }}
                            </address>
                        </div><!-- End .contact-box -->
                    </div><!-- End .col-md-4 -->

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Start a Conversation</h3>

                            <div><a
                                    href="mailto:{{ \App\Models\Setting::where('key', 'email')->value('value') ?? '#' }}">{{ \App\Models\Setting::where('key', 'email')->value('value') ?? 'info@Molla.com' }}</a>
                            </div>
                            <div><a
                                    href="tel:{{ \App\Models\Setting::where('key', 'mobile')->value('value') ?? '#' }}">{{ \App\Models\Setting::where('key', 'mobile')->value('value') ?? '+1 987-876-6543' }}</a>
                                @if (\App\Models\Setting::where('key', 'alternative_mobile')->value('value'))
                                    ,
                                    <a
                                        href="tel:{{ \App\Models\Setting::where('key', 'alternative_mobile')->value('value') }}">{{ \App\Models\Setting::where('key', 'alternative_mobile')->value('value') }}</a>
                                @endif
                            </div>
                        </div><!-- End .contact-box -->
                    </div><!-- End .col-md-4 -->

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Social</h3>

                            <div class="social-icons social-icons-color justify-content-center">
                                @if (\App\Models\Setting::where('key', 'facebook_link')->value('value'))
                                    <a href="{{ \App\Models\Setting::where('key', 'facebook_link')->value('value') }}"
                                        class="social-icon social-facebook" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                @endif
                                @if (\App\Models\Setting::where('key', 'twitter_link')->value('value'))
                                    <a href="{{ \App\Models\Setting::where('key', 'twitter_link')->value('value') }}"
                                        class="social-icon social-twitter" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                @endif
                                @if (\App\Models\Setting::where('key', 'instagram_link')->value('value'))
                                    <a href="{{ \App\Models\Setting::where('key', 'instagram_link')->value('value') }}"
                                        class="social-icon social-instagram" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                @endif
                                @if (\App\Models\Setting::where('key', 'youtube_link')->value('value'))
                                    <a href="{{ \App\Models\Setting::where('key', 'youtube_link')->value('value') }}"
                                        class="social-icon social-youtube" title="Youtube" target="_blank"><i
                                            class="icon-youtube"></i></a>
                                @endif
                                @if (\App\Models\Setting::where('key', 'pinterest_link')->value('value'))
                                    <a href="{{ \App\Models\Setting::where('key', 'pinterest_link')->value('value') }}"
                                        class="social-icon social-pinterest" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                @endif
                            </div><!-- End .soial-icons -->
                        </div><!-- End .contact-box -->
                    </div><!-- End .col-md-4 -->
                </div><!-- End .row -->

                <hr class="mt-3 mb-5 mt-md-1">
                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center">
                            <h2 class="title mb-1">Get In Touch</h2><!-- End .title mb-2 -->
                            <p class="lead text-primary">
                                We collaborate with ambitious brands and people; we’d love to build something great
                                together.
                            </p><!-- End .lead text-primary -->
                            <p class="mb-3">Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu
                                pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus
                                sed, urna.</p>
                        </div><!-- End .text-center -->

                        <!-- Debug: Turnstile Site Key = {{ env('TURNSTILE_SITE_KEY', 'NOT_SET') }} -->
                        <form action="{{ route('contact.store') }}" method="POST" class="contact-form mb-2">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="cname" class="sr-only">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="cname" name="name" placeholder="Name *" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div><!-- End .col-sm-4 -->

                                <div class="col-sm-4">
                                    <label for="cemail" class="sr-only">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="cemail" name="email" placeholder="Email *" value="{{ old('email') }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div><!-- End .col-sm-4 -->

                                <div class="col-sm-4">
                                    <label for="cphone" class="sr-only">Phone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="cphone" name="phone" placeholder="Phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div><!-- End .col-sm-4 -->
                            </div><!-- End .row -->

                            <label for="csubject" class="sr-only">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                id="csubject" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="cmessage" class="sr-only">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" cols="30" rows="4" id="cmessage"
                                name="message" required placeholder="Message *">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @php
                                // dd(env('TURNSTILE_SITE_KEY'))
                            @endphp
                            <div class="form-group mt-3">
                                <div class="cf-turnstile"
                                    data-sitekey="{{ \App\Models\Setting::where('key', 'turnstile_site_key')->value('value') ?: env('TURNSTILE_SITE_KEY', '0x4AAAAAAB3Iy57TrSk_p0q4') }}"
                                    data-callback="onTurnstileCallback"></div>
                                <input type="hidden" name="cf-turnstile-response" value="">
                                @error('cf-turnstile-response')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                    <span>SUBMIT</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                            </div><!-- End .text-center -->
                        </form><!-- End .contact-form -->
                    </div><!-- End .col-md-9 col-lg-7 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection

@section('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        function onTurnstileCallback(token) {
            document.querySelector('input[name="cf-turnstile-response"]').value = token;
        }
    </script>
@endsection
