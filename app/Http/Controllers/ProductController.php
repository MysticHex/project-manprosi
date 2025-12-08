<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProducts($request->all());
        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        return view('products.show', compact('product'));
    }
}
