<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        $partners = [
            [
                'name' => 'Apple',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Apple-Logo.png',
                'link' => 'https://apple.com',
                'status' => true,
            ],
            [
                'name' => 'Samsung',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Samsung-Logo.png',
                'link' => 'https://samsung.com',
                'status' => true,
            ],
            [
                'name' => 'Nike',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Nike-Logo.png',
                'link' => 'https://nike.com',
                'status' => true,
            ],
            [
                'name' => 'Adidas',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Adidas-Logo.png',
                'link' => 'https://adidas.com',
                'status' => true,
            ],
            [
                'name' => 'Sony',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Sony-Logo.png',
                'link' => 'https://sony.com',
                'status' => true,
            ],
            [
                'name' => 'Dell',
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Dell-Logo.png',
                'link' => 'https://dell.com',
                'status' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}