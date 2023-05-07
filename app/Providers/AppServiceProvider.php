<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\BaseService;
use App\Services\ProfileService;
use App\Services\TestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseService::class, function ($app) {
            return new BaseService();
        });

        $this->app->bind(TestService::class, function ($app) {
            return new TestService();
        });

        $this->app->bind(ProfileService::class, function ($app) {
            return new ProfileService();
        });

        $this->app->bind(ArticleService::class, function ($app) {
            return new ArticleService();
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
