<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        
        $categories = ['Vegetables', 'Fruits', 'Meat', 'Dairy', 'Beverages'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat, 'slug' => Str::slug($cat)]);
        }

        $brands = ['FarmFresh', 'OrganicLife', 'DailyDairy', 'MeatLovers'];
        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand, 'slug' => Str::slug($brand)]);
        }

        $products = [
            ['name' => 'Fresh Spinach', 'category' => 'Vegetables', 'price' => 2.50],
            ['name' => 'Red Apple', 'category' => 'Fruits', 'price' => 1.20],
            ['name' => 'Chicken Breast', 'category' => 'Meat', 'price' => 5.50],
            ['name' => 'Milk 1L', 'category' => 'Dairy', 'price' => 1.50],
            ['name' => 'Orange Juice', 'category' => 'Beverages', 'price' => 3.00],
            ['name' => 'Broccoli', 'category' => 'Vegetables', 'price' => 1.80],
            ['name' => 'Banana', 'category' => 'Fruits', 'price' => 0.80],
            ['name' => 'Beef Steak', 'category' => 'Meat', 'price' => 12.00],
        ];

        foreach ($products as $p) {
            Product::create([
                'user_id' => $user->id,
                'category_id' => Category::where('name', $p['category'])->first()->id,
                'brand_id' => Brand::inRandomOrder()->first()->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'Fresh and high quality ' . $p['name'],
                'price' => $p['price'],
                'stock' => 100,
                'is_active' => true,
            ]);
        }
    }
}
