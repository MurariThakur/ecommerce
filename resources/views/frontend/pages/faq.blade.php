@extends('frontend.layouts.app')
@section('title', 'FAQ')

@section('styles')
    <style>
        .faq-header {
            background: linear-gradient(135deg, #c96 0%, #bf8040 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 0;
        }

        .faq-search {
            background: white;
            border-radius: 25px;
            padding: 15px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .faq-search input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
        }

        .faq-search i {
            color: #c96;
            font-size: 18px;
        }

        .faq-categories {
            background: #f8f9fa;
            padding: 2rem 0;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .category-card:hover,
        .category-card.active {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #c96;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #c96 0%, #bf8040 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 24px;
        }

        .faq-accordion {
            margin-top: 3rem;
        }

        .faq-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .faq-question {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 1.5rem 2rem;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: #f8f9fa;
            color: #c96;
        }

        .faq-question.active {
            background: linear-gradient(135deg, #c96 0%, #bf8040 100%);
            color: white;
        }

        .faq-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .faq-question.active .faq-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: rotate(45deg);
        }

        .faq-answer {
            padding: 0 2rem 1.5rem;
            color: #666;
            line-height: 1.6;
            display: none;
        }

        .faq-answer.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 0;
            margin-top: 3rem;
            border-radius: 20px;
        }

        .contact-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .btn-contact {
            background: linear-gradient(135deg, #c96 0%, #bf8040 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 153, 102, 0.4);
            color: white;
        }

        @media (max-width: 768px) {
            .faq-header {
                padding: 2rem 0;
            }

            .category-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .faq-question {
                padding: 1rem 1.5rem;
                font-size: 15px;
            }

            .faq-answer {
                padding: 0 1.5rem 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <main class="main">
         <div class="page-header text-center" style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">FAQ<span>Frequently Asked Questions</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </div>
        </nav>

        <div class="faq-categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="category-card active" data-category="orders">
                            <div class="category-icon">
                                <i class="icon-shopping-cart"></i>
                            </div>
                            <h5>Orders</h5>
                            <p class="text-muted small">Placing & managing orders</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="category-card" data-category="shipping">
                            <div class="category-icon">
                                <i class="icon-truck"></i>
                            </div>
                            <h5>Shipping</h5>
                            <p class="text-muted small">Delivery & tracking</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="category-card" data-category="returns">
                            <div class="category-icon">
                                <i class="icon-refresh"></i>
                            </div>
                            <h5>Returns</h5>
                            <p class="text-muted small">Returns & exchanges</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="category-card" data-category="account">
                            <div class="category-icon">
                                <i class="icon-user"></i>
                            </div>
                            <h5>Account</h5>
                            <p class="text-muted small">Profile & settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="faq-accordion">
                            @forelse($faqs as $index => $faq)
                                <div class="faq-item" data-category="{{ $faq->category }}">
                                    <button class="faq-question {{ $index === 0 ? 'active' : '' }}" data-target="faq{{ $faq->id }}">
                                        <span>{{ $faq->question }}</span>
                                        <div class="faq-icon"><i class="icon-plus"></i></div>
                                    </button>
                                    <div class="mt-1 faq-answer {{ $index === 0 ? 'show' : '' }}" id="faq{{ $faq->id }}">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="icon-question-circle" style="font-size: 4rem; color: #ddd;"></i>
                                    <h4 class="mt-3 text-muted">No FAQs Available</h4>
                                    <p class="text-muted">Check back later for frequently asked questions.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="contact-card">
                            <h3 class="mb-3">Still have questions?</h3>
                            <p class="text-muted mb-4">Can't find the answer you're looking for? Our customer support team
                                is here to help.</p>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <a href="{{ route('contact') }}" class="btn btn-contact btn-block">
                                        <i class="icon-envelope mr-2"></i>Contact Support
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ Accordion functionality
            const faqQuestions = document.querySelectorAll('.faq-question');
            const faqItems = document.querySelectorAll('.faq-item');
            const categoryCards = document.querySelectorAll('.category-card');
            const searchInput = document.getElementById('faqSearch');

            // Handle FAQ question clicks
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const answer = document.getElementById(targetId);
                    const isActive = this.classList.contains('active');

                    // Close all other FAQs
                    faqQuestions.forEach(q => {
                        q.classList.remove('active');
                        const answerId = q.getAttribute('data-target');
                        const answerEl = document.getElementById(answerId);
                        answerEl.classList.remove('show');
                    });

                    // Toggle current FAQ
                    if (!isActive) {
                        this.classList.add('active');
                        answer.classList.add('show');
                    }
                });
            });

            // Handle category filtering
            categoryCards.forEach(card => {
                card.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // Update active category
                    categoryCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Filter FAQ items
                    faqItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        if (itemCategory === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Close all open FAQs when switching categories
                    faqQuestions.forEach(q => {
                        q.classList.remove('active');
                        const answerId = q.getAttribute('data-target');
                        const answerEl = document.getElementById(answerId);
                        answerEl.classList.remove('show');
                    });
                });
            });

            // Handle search functionality
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    faqItems.forEach(item => {
                        const question = item.querySelector('.faq-question span').textContent
                            .toLowerCase();
                        const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // If searching, remove category filter
                    if (searchTerm) {
                        categoryCards.forEach(c => c.classList.remove('active'));
                    }
                });
            }

            // Initialize - show orders category by default
            const ordersCategory = document.querySelector('[data-category="orders"]');
            if (ordersCategory) {
                ordersCategory.click();
            }
        });
    </script>
@endsection
