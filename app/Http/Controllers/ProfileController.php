<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ProfileController extends Controller
{
    public function index()
    {
        return inertia('Profile/Index', [
            'name' => \Auth::user()->name,
            'totalPointsCount' => self::getTotalPointsCount(),
            'currentPointsCount' => self::getCurrentPointsCount()
        ]);
    }

    public static function getTotalPointsCount()
    {
        return Article::all()->count() + (TestController::getAvailableCategoriesWithTest()->count() * 2);
    }

    public static function getCurrentPointsCount()
    {
        return (count(TestController::getUserTestCategories()) * 2) + count(ArticleController::getReadArticles());
    }


}
