<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public function getLatestBlogs($limit = 3)
    {
        return Blog::latest()->take($limit)->get();
    }
}
