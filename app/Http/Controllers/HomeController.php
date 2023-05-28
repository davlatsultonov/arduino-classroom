<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::withWhereHas('category', fn($q) => $q->where('slug', '!=', 'tutorials'))
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy('category.name');

        $iotArticlesThumbnails = ArticleService::getIoTArticlesThumbnails();

        return inertia('Home', compact('articles', 'iotArticlesThumbnails'));
    }
}
