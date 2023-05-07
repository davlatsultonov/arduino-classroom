<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleRead;
use Illuminate\Support\Facades\Facade;

class ArticleService extends Facade
{
    public static function getTopArticles()
    {
        return Article::popular()
            ->withWhereHas('category', fn($q) => $q->where('slug', '!=', 'tutorials'))
            ->take(10)
            ->orderBy('views', 'desc')
            ->get();
    }

    public static function getReadArticles()
    {
        return ArticleRead::where('user_id', auth()->user()->id)->pluck('article_id');
    }

    public static function getTutorialPageArticles()
    {
        return Article::with(['sub_category', 'category' => fn($q) => $q->whereSlug('tutorials')])
            ->orderByOrder()
            ->get()
            ->sortBy(function ($item) {
                return $item->sub_category->order;
            })
            ->groupBy('sub_category.name');
    }
}

