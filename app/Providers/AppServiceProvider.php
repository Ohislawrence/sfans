<?php

namespace App\Providers;

use App\Services\AffiliateAdService;
use App\Services\VisitorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AffiliateAdService::class, function ($app) {
            return new AffiliateAdService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
