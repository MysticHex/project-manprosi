<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts($filters = [])
    {
        $query = Product::query()->where('is_active', true);

        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (isset($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate(12);
    }

    public function getProductBySlug($slug)
    {
        return Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function getTrendingProducts($limit = 8)
    {
        // Logic for trending (e.g., most viewed or random for now)
        return Product::where('is_active', true)->inRandomOrder()->take($limit)->get();
    }

    public function getBestSellers($limit = 8)
    {
        // Logic for best sellers (e.g., most sold)
        return Product::where('is_active', true)->orderBy('stock', 'asc')->take($limit)->get(); // Mock logic
    }
}
