<?php

namespace App\Http\Controllers;

use App\Services\BannerService;
use App\Services\BlogService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;
    protected $bannerService;
    protected $blogService;

    public function __construct(ProductService $productService, BannerService $bannerService, BlogService $blogService)
    {
        $this->productService = $productService;
        $this->bannerService = $bannerService;
        $this->blogService = $blogService;
    }

    public function index()
    {
        $banners = $this->bannerService->getBanners();
        $trendingProducts = $this->productService->getTrendingProducts();
        $bestSellers = $this->productService->getBestSellers();
        $blogs = $this->blogService->getLatestBlogs();

        return view('home', compact('banners', 'trendingProducts', 'bestSellers', 'blogs'));
    }
}
