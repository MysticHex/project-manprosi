<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannersSeeder extends Seeder
{
    public function run(): void
    {
        Banner::create([
            'title' => 'Fresh Vegetables Big Sale',
            'image' => 'https://via.placeholder.com/1200x400',
            'url' => '/products',
            'type' => 'hero',
            'priority' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Organic Fruits',
            'image' => 'https://via.placeholder.com/1200x400',
            'url' => '/products?category=fruits',
            'type' => 'hero',
            'priority' => 2,
            'is_active' => true,
        ]);
    }
}
