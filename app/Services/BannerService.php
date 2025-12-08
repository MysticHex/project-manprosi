<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{
    public function getBanners()
    {
        return Banner::where('is_active', true)->get();
    }
}
