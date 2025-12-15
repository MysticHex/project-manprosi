<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // When behind a TLS-terminating proxy (ngrok) requests may be forwarded
        // as HTTP but include X-Forwarded-Proto: https. Force URL generation
        // to use https in that case so assets and form actions are generated
        // with https and avoid mixed-content blocks.
        try {
            $forwardedProto = null;
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_SCHEME'])) {
                $forwardedProto = $_SERVER['HTTP_X_FORWARDED_SCHEME'];
            }

            if (env('FORCE_HTTPS', false) || $forwardedProto === 'https') {
                URL::forceScheme('https');
            }
        } catch (\Throwable $e) {
            // don't break the app if headers aren't available
        }

        // Provide categories to the footer component from the database
        try {
            View::composer('components.footer', function ($view) {
                $view->with('categories', Category::orderBy('name')->get());
            });
        } catch (\Throwable $e) {
            // fail silently if models or views aren't available yet
        }
    }
}
