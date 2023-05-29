<?php

namespace App\Http\Controllers;


use App\Models\Article;
use Diglactic\Breadcrumbs\Breadcrumbs;

class CategoryController extends Controller
{
    /**
     * Отображает страницу со списком статей для указанной категории.
     *
     * @param string $slug Slug категории.
     * @return \Inertia\Response
     */
    public function index($slug)
    {
        // Генерируем данные для хлебных крошек
        $breadcrumbs = Breadcrumbs::render('category.index', $slug)->getData();

        // Получаем статьи с указанной категорией
        $articles = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereSlug($slug))
            ->get();

        // Возвращаем отклик с использованием Inertia.js и переданными данными
        return inertia('Articles/Index', compact('articles', 'breadcrumbs'));
    }
}
