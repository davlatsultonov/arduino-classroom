<?php

namespace App\Services;

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Support\Facades\Facade;

class ProfileService extends Facade
{
    /**
     * Получает общее количество баллов.
     *
     * @return float|int - общее количество баллов
     */
    public static function getTotalPointsCount(): float|int
    {
        return Article::count() + (TestService::getAvailableCategoriesWithTest()->count() * 2);
    }

    /**
     * Получает текущее количество баллов.
     *
     * @return float|int - текущее количество баллов
     */
    public static function getCurrentPointsCount(): float|int
    {
        return (count(TestService::getUserTestCategories()) * 2) + count(ArticleService::getReadArticles());
    }
}

