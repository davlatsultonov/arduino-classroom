<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;

class HomeController extends Controller
{
    /**
     * Отображает главную страницу со списком статей.
     */
    public function index()
    {
        // Получение списка статей с использованием отношения "withWhereHas"
        // Фильтруются статьи, у которых связанная категория не равна 'tutorials'
        // Список статей сортируется по дате создания в порядке убывания
        // Результат группируется по имени категории
        $articles = Article::withWhereHas('category', fn($q) => $q->where('slug', '!=', 'tutorials'))
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy('category.name');

        // Получение миниатюр статей по категории "IoT"
        $iotArticlesThumbnails = ArticleService::getIoTArticlesThumbnails();

        // Отображение главной страницы с передачей данных статей и миниатюр статей IoT
        return inertia('Home', compact('articles', 'iotArticlesThumbnails'));
    }
}
