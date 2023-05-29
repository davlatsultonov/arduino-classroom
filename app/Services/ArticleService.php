<?php

namespace App\Services;

use App\Models\Article;
use App\Models\SubCategory;
use App\Models\ArticleRead;
use Illuminate\Support\Facades\Facade;

class ArticleService extends Facade
{
    /**
     * Получает популярные статьи.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция популярных статей
     */
    public static function getTopArticles()
    {
        return Article::popular()
            ->withWhereHas('category', fn($q) => $q->where('slug', '!=', 'tutorials'))
            ->take(10)
            ->orderBy('views', 'desc')
            ->get();
    }

    /**
     * Получает прочитанные статьи пользователя.
     *
     * @return \Illuminate\Support\Collection - коллекция ID прочитанных статей
     */
    public static function getReadArticles()
    {
        return ArticleRead::where('user_id', auth()->user()->id)->pluck('article_id');
    }

    /**
     * Получает статьи для страницы учебника.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция статей для страницы учебника, сгруппированные по категориям
     */
    public static function getTutorialPageArticles()
    {
        return SubCategory::with('category')->withWhereHas('articles')
            ->get()->groupBy('category.name');
    }

    /**
     * Получает миниатюры статей по IoT.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция миниатюр статей по IoT
     */
    public static function getIoTArticlesThumbnails() {
        return Article::query()->withWhereHas('sub_category', fn($q) => $q->whereSlug('arduino-iot'))->select('image', 'slug')->get();
    }
}

