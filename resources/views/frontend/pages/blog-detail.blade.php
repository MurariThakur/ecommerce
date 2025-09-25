@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">{{ $blog->title }}</h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.blog') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 50) }}</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <article class="entry single-entry">
                            <figure class="entry-media">
                                <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('frontend/assets/images/blog/single/post-1.jpg') }}"
                                    alt="{{ $blog->title }}">
                            </figure>

                            <div class="entry-body">
                                <div class="entry-meta">
                                    <a href="#">{{ $blog->created_at->format('M d, Y') }}</a>
                                    <span class="meta-separator">|</span>
                                    <a href="#">2 Comments</a>
                                    <span class="meta-separator">|</span>
                                    <a
                                        href="{{ route('frontend.blog') }}?category={{ $blog->blogCategory->id }}">{{ $blog->blogCategory->name }}</a>

                                </div>

                                <h1 class="entry-title entry-title-big">{{ $blog->title }}</h1>

                                <div class="entry-content editor-content">
                                    {!! $blog->description !!}
                                </div>


                            </div>
                        </article>

                        <div class="related-posts">
                            <h3 class="title">Related Posts</h3><!-- End .title -->

                            @if ($relatedBlogs->count() > 0)
                                <div class="owl-carousel owl-simple" data-toggle="owl"
                                    data-owl-options='{
                                        "nav": false, 
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":1
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            }
                                        }
                                    }'>
                                    @foreach ($relatedBlogs as $relatedBlog)
                                        <article class="entry entry-grid">
                                            <figure class="entry-media">
                                                <a href="{{ route('frontend.blog.detail', $relatedBlog->slug) }}">
                                                    <img src="{{ $relatedBlog->image ? asset('storage/' . $relatedBlog->image) : asset('frontend/assets/images/blog/grid/3cols/post-1.jpg') }}"
                                                        alt="{{ $relatedBlog->title }}">
                                                </a>
                                            </figure>

                                            <div class="entry-body">
                                                <div class="entry-meta">
                                                    <a href="#">{{ $relatedBlog->created_at->format('M d, Y') }}</a>
                                                </div>

                                                <h2 class="entry-title">
                                                    <a
                                                        href="{{ route('frontend.blog.detail', $relatedBlog->slug) }}">{{ Str::limit($relatedBlog->title, 40) }}</a>
                                                </h2>

                                                <div class="entry-cats">
                                                    in <a
                                                        href="{{ route('frontend.blog') }}?category={{ $relatedBlog->blogCategory->id }}">{{ $relatedBlog->blogCategory->name }}</a>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @else
                                <p>No related posts found.</p>
                            @endif
                        </div><!-- End .related-posts -->

                        <!-- Comments Section -->
                        <div class="comments">
                            <h3 class="title">{{ $blog->comments->where('status', true)->count() }} Comments</h3>
                            <!-- End .title -->

                            <ul>
                                @forelse($blog->comments->where('status', true) as $comment)
                                    <li>
                                        <div class="comment">


                                            <div class="comment-body">

                                                <div class="comment-user">
                                                    <h4><a href="#">{{ $comment->user->name }}</a></h4>
                                                    <span
                                                        class="comment-date">{{ $comment->created_at->format('M d, Y \a\t g:i A') }}</span>
                                                </div><!-- End .comment-user -->

                                                <div class="comment-content">
                                                    <p>{{ $comment->comment }}</p>
                                                </div><!-- End .comment-content -->
                                            </div><!-- End .comment-body -->
                                        </div><!-- End .comment -->
                                    </li>
                                @empty
                                    <p>No comments yet. Be the first to comment!</p>
                                @endforelse
                            </ul>
                        </div><!-- End .comments -->

                        <div class="reply">
                            <div class="heading">
                                <h3 class="title">Leave A Comment</h3>
                                @auth
                                    <p class="title-desc">Share your thoughts about this post.</p>
                                @else
                                    <p class="title-desc">Please <a href="#signin-modal" data-toggle="modal">login</a> to leave
                                        a comment.</p>
                                @endauth
                            </div>

                            @auth
                                <form action="{{ route('frontend.blog.comment', $blog->slug) }}" method="POST">
                                    @csrf
                                    <label for="comment" class="sr-only">Comment</label>
                                    <textarea name="comment" id="comment" cols="30" rows="4" class="form-control" required
                                        placeholder="Write your comment here...">{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror

                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>POST COMMENT</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            @else
                                <form id="comment-form">
                                    <label for="comment-guest" class="sr-only">Comment</label>
                                    <textarea id="comment-guest" cols="30" rows="4" class="form-control" required
                                        placeholder="Please login to comment..."></textarea>

                                    <button type="button" class="btn btn-outline-primary-2" data-toggle="modal"
                                        data-target="#signin-modal">
                                        <span>LOGIN TO COMMENT</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>

                    <aside class="col-lg-3">
                        <div class="sidebar">
                            <div class="widget widget-search">
                                <h3 class="widget-title">Search</h3>
                                <form action="{{ route('frontend.blog') }}" method="GET">
                                    <label for="ws" class="sr-only">Search in blog</label>
                                    <input type="search" class="form-control" name="search" id="ws"
                                        placeholder="Search in blog" required>
                                    <button type="submit" class="btn"><i class="icon-search"></i></button>
                                </form>
                            </div>

                            <div class="widget widget-cats">
                                <h3 class="widget-title">Categories</h3>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('frontend.blog') }}?category={{ $category->id }}">{{ $category->name }}<span>{{ $category->blogs_count }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title">Recent Posts</h3>
                                <ul class="posts-list">
                                    @foreach ($recentBlogs as $recentBlog)
                                        <li>
                                            <figure>
                                                <a href="{{ route('frontend.blog.detail', $recentBlog->slug) }}">
                                                    <img src="{{ $recentBlog->image ? asset('storage/' . $recentBlog->image) : asset('frontend/assets/images/blog/sidebar/post-1.jpg') }}"
                                                        alt="{{ $recentBlog->title }}">
                                                </a>
                                            </figure>

                                            <div>
                                                <span>{{ $recentBlog->created_at->format('M d, Y') }}</span>
                                                <h4><a
                                                        href="{{ route('frontend.blog.detail', $recentBlog->slug) }}">{{ Str::limit($recentBlog->title, 40) }}</a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
@endsection
