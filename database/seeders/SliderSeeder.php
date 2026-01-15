<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $sliders = [
            [
                'title' => 'Latest Electronics & Gadgets',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200',
                'button_name' => 'Shop Now',
                'button_link' => '/electronics',
                'status' => true,
            ],
            [
                'title' => 'Fashion Trends 2024',
                'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1200',
                'button_name' => 'Explore Fashion',
                'button_link' => '/fashion',
                'status' => true,
            ],
            [
                'title' => 'Transform Your Home',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200',
                'button_name' => 'Shop Home',
                'button_link' => '/home-garden',
                'status' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}