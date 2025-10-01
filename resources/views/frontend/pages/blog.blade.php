@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">Blogs</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <nav class="blog-nav">
                    <ul class="menu-cat entry-filter justify-content-center">
                        <li class="{{ !request('category') ? 'active' : '' }}">
                            <a href="{{ route('frontend.blog') }}">All Posts<span>{{ $blogs->total() }}</span></a>
                        </li>
                        @foreach ($categories as $category)
                            <li class="{{ request('category') == $category->id ? 'active' : '' }}">
                                <a
                                    href="{{ route('frontend.blog') }}?category={{ $category->id }}">{{ $category->name }}<span>{{ $category->blogs_count }}</span></a>
                            </li>
                        @endforeach
                    </ul><!-- End .blog-menu -->
                </nav><!-- End .blog-nav -->

                <div class="entry-container max-col-3" data-layout="fitRows">
                    @forelse($blogs as $blog)
                        <div class="entry-item lifestyle shopping col-sm-6 col-lg-4">
                            <article class="entry entry-grid text-center">
                                <figure class="entry-media">
                                    <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                        <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('frontend/assets/images/blog/grid/3cols/post-1.jpg') }}"
                                            alt="{{ $blog->title }}">
                                    </a>
                                </figure><!-- End .entry-media -->

                                <div class="entry-body">
                                    <div class="entry-meta">
                                        <span class="meta-separator">|</span>
                                        <a href="#">{{ $blog->created_at->format('M d, Y') }}</a>
                                        <span class="meta-separator">|</span>
                                        <a href="#">2 Comments</a>
                                    </div><!-- End .entry-meta -->

                                    <h2 class="entry-title">
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h2><!-- End .entry-title -->

                                    <div class="entry-cats">
                                        in <a
                                            href="{{ route('frontend.blog') }}?category={{ $blog->blogCategory->id }}">{{ $blog->blogCategory->name }}</a>
                                    </div>

                                    <div class="entry-content">
                                        <p>{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}"
                                            class="read-more">Continue Reading</a>
                                    </div><!-- End .entry-content -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                        </div><!-- End .entry-item -->
                    @empty
                        <div class="col-12 text-center">
                            <p>No blog posts found.</p>
                        </div>
                    @endforelse
                </div><!-- End .entry-container -->
                @if ($blogs->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1"
                                    aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item">
                                <a class="page-link page-link-next" href="#" aria-label="Next">
                                    Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
