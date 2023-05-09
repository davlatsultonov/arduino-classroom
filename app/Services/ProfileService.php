<?php

namespace App\Services;

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Support\Facades\Facade;

class ProfileService extends Facade
{
    public static function getTotalPointsCount(): float|int
    {
        return Article::count() + (TestService::getAvailableCategoriesWithTest()->count() * 2);
    }

    public static function getCurrentPointsCount(): float|int
    {
        return (count(TestService::getUserTestCategories()) * 2) + count(ArticleService::getReadArticles());
    }
}

