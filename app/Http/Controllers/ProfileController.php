<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\TestService;

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

    public function getTotalPointsCount()
    {
        return Article::count() + (TestService::getAvailableCategoriesWithTest()->count() * 2);
    }

    public function getCurrentPointsCount()
    {
        return (count(TestService::getUserTestCategories()) * 2) + count(ArticleController::getReadArticles());
    }


}
