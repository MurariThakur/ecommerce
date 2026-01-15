<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Create blog categories
        $categories = [
            ['name' => 'Technology', 'meta_title' => 'Technology News & Reviews', 'meta_description' => 'Latest technology news, reviews, and insights.', 'meta_keyword' => 'technology, tech news, reviews', 'status' => true],
            ['name' => 'Fashion', 'meta_title' => 'Fashion Trends & Style', 'meta_description' => 'Fashion trends, style tips, and industry news.', 'meta_keyword' => 'fashion, style, trends', 'status' => true],
            ['name' => 'Lifestyle', 'meta_title' => 'Lifestyle & Wellness', 'meta_description' => 'Lifestyle tips, wellness advice, and life inspiration.', 'meta_keyword' => 'lifestyle, wellness, health', 'status' => true],
        ];

        foreach ($categories as $category) {
            $category['isdelete'] = false;
            BlogCategory::create($category);
        }

        // Create blog posts
        $blogs = [
            [
                'title' => 'The Future of Smartphone Technology',
                'category' => 'Technology',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800',
                'short_description' => 'Exploring the latest innovations in smartphone technology and what to expect in 2024.',
                'description' => 'Smartphone technology continues to evolve at a rapid pace. From foldable displays to AI-powered cameras, manufacturers are pushing the boundaries of what\'s possible. In this comprehensive guide, we explore the latest innovations including 5G connectivity, advanced camera systems, and sustainable manufacturing practices. We also look ahead to emerging technologies like holographic displays and brain-computer interfaces that could revolutionize how we interact with our devices.',
                'meta_title' => 'Future of Smartphone Technology 2024',
                'meta_description' => 'Discover the latest smartphone innovations and future technology trends.',
                'meta_keyword' => 'smartphone, technology, innovation, 2024',
                'status' => true,
            ],
            [
                'title' => 'Sustainable Fashion: A Growing Trend',
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800',
                'short_description' => 'How sustainable fashion is reshaping the industry and what consumers need to know.',
                'description' => 'The fashion industry is undergoing a significant transformation as consumers become more environmentally conscious. Sustainable fashion encompasses everything from eco-friendly materials to ethical manufacturing practices. This article explores the rise of circular fashion, the importance of transparency in supply chains, and how brands are adapting to meet consumer demand for responsible fashion choices. We also provide practical tips for building a sustainable wardrobe.',
                'meta_title' => 'Sustainable Fashion Trends 2024',
                'meta_description' => 'Learn about sustainable fashion trends and eco-friendly clothing choices.',
                'meta_keyword' => 'sustainable fashion, eco-friendly, ethical fashion',
                'status' => true,
            ],
            [
                'title' => 'Creating a Productive Home Office Space',
                'category' => 'Lifestyle',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800',
                'short_description' => 'Essential tips for designing a home office that boosts productivity and well-being.',
                'description' => 'With remote work becoming increasingly common, creating an effective home office space is more important than ever. This comprehensive guide covers everything from choosing the right furniture and lighting to organizing your workspace for maximum efficiency. We discuss the importance of ergonomics, the role of natural light in productivity, and how to create boundaries between work and personal life. Additionally, we explore budget-friendly solutions and DIY projects to transform any space into a productive work environment.',
                'meta_title' => 'Home Office Design Tips for Productivity',
                'meta_description' => 'Create the perfect home office with our expert design and productivity tips.',
                'meta_keyword' => 'home office, productivity, workspace design, remote work',
                'status' => true,
            ],
            [
                'title' => 'Top 10 Fitness Gadgets for 2024',
                'category' => 'Technology',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800',
                'short_description' => 'Discover the latest fitness technology to help you achieve your health goals.',
                'description' => 'Fitness technology has revolutionized how we approach health and wellness. From advanced smartwatches that monitor heart rate variability to AI-powered personal trainers, these gadgets are making it easier than ever to stay fit and healthy. This article reviews the top 10 fitness gadgets of 2024, including wearable devices, smart home gym equipment, and recovery tools. We evaluate each product based on features, accuracy, user experience, and value for money.',
                'meta_title' => 'Best Fitness Gadgets 2024 - Complete Review',
                'meta_description' => 'Comprehensive review of the top fitness gadgets and wearable technology.',
                'meta_keyword' => 'fitness gadgets, wearable technology, health tech, smartwatch',
                'status' => true,
            ],
            [
                'title' => 'Minimalist Wardrobe: Quality Over Quantity',
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800',
                'short_description' => 'Building a minimalist wardrobe with timeless pieces that never go out of style.',
                'description' => 'The minimalist wardrobe concept focuses on owning fewer, higher-quality pieces that can be mixed and matched to create multiple outfits. This approach not only simplifies your daily routine but also promotes sustainable consumption. In this guide, we explore the principles of minimalist fashion, how to identify your personal style, and the essential pieces every wardrobe should have. We also provide tips for decluttering your current wardrobe and investing in quality pieces that will last for years.',
                'meta_title' => 'Minimalist Wardrobe Guide - Quality Fashion',
                'meta_description' => 'Learn how to build a minimalist wardrobe with timeless, quality pieces.',
                'meta_keyword' => 'minimalist wardrobe, capsule wardrobe, quality fashion, timeless style',
                'status' => true,
            ],
        ];

        foreach ($blogs as $blogData) {
            $category = BlogCategory::where('name', $blogData['category'])->first();
            
            Blog::create([
                'title' => $blogData['title'],
                'blog_category_id' => $category->id,
                'image' => $blogData['image'],
                'short_description' => $blogData['short_description'],
                'description' => $blogData['description'],
                'meta_title' => $blogData['meta_title'],
                'meta_description' => $blogData['meta_description'],
                'meta_keyword' => $blogData['meta_keyword'],
                'status' => $blogData['status'],
                'isdelete' => false,
            ]);
        }
    }
}