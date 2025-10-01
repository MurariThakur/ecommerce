<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'How do I place an order?',
                'answer' => 'Simply browse our products, add items to your cart, and proceed to checkout. Follow the step-by-step process to complete your order. You can also create an account for faster checkout in the future.',
                'category' => 'orders',
                'status' => true,
                'sort_order' => 1
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and Cash on Delivery (COD) for your convenience. All payments are processed securely.',
                'category' => 'orders',
                'status' => true,
                'sort_order' => 2
            ],
            [
                'question' => 'How long does shipping take?',
                'answer' => 'Standard shipping takes 3-5 business days. Express shipping is available for 1-2 business days delivery. Free shipping is available on orders over $50.',
                'category' => 'shipping',
                'status' => true,
                'sort_order' => 3
            ],
            [
                'question' => 'How can I track my order?',
                'answer' => 'Once your order ships, you\'ll receive a tracking number via email. You can also track orders in your account dashboard or use our order tracking page.',
                'category' => 'shipping',
                'status' => true,
                'sort_order' => 4
            ],
            [
                'question' => 'Can I return or exchange items?',
                'answer' => 'Yes, we offer a 30-day return policy. Items must be in original condition with tags attached. Returns are free and easy through our return portal.',
                'category' => 'returns',
                'status' => true,
                'sort_order' => 5
            ],
            [
                'question' => 'How do I create an account?',
                'answer' => 'Click on the "Login" button in the header and select "Create Account". Fill in your details and verify your email address to get started.',
                'category' => 'account',
                'status' => true,
                'sort_order' => 6
            ],
            [
                'question' => 'How do I reset my password?',
                'answer' => 'On the login page, click "Forgot Password" and enter your email address. You\'ll receive a password reset link within a few minutes.',
                'category' => 'account',
                'status' => true,
                'sort_order' => 7
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}