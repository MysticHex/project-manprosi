<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        
        $categories = ['Makanan', 'Minuman', "Paket"];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat, 'slug' => Str::slug($cat)]);
        }


        $products = [
            ['name' => 'Nasi Kuning Tumpeng', 'category' => 'Makanan', 'price' => 150000]
        ];

        foreach ($products as $p) {
            $prod = Product::create([
                'user_id' => $user->id,
                'category_id' => Category::where('name', $p['category'])->first()->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'Fresh and high quality ' . $p['name'],
                'price' => $p['price'],
                'stock' => 100,
                'is_active' => true,
            ]);

            // attach default product image (ensure this file exists in storage/app/public/products)
            try {
                ProductImage::firstOrCreate([
                    'product_id' => $prod->id,
                    'image_path' => 'products/8mwKowzxGLIqsPBo55p0lc9zfLZoSUOUX44iBuey.jpg',
                ]);
            } catch (\Throwable $e) {
                // silently ignore if model/table isn't available during certain runs
            }
        }
    }
}
