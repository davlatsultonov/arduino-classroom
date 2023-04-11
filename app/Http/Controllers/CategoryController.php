<?php

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $breadcrumbs = Breadcrumbs::render('category.index', $slug)->getData();
        $articles = Article::join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('articles.*', 'categories.slug as category_slug', 'categories.name as category_name')
            ->where('categories.slug', $slug)->get();

        return inertia('Articles/Index', compact('articles', 'breadcrumbs'));
    }

    public static function getCategoryNameBySlug($slug)
    {
        return Category::firstWhere('slug', $slug)->name;
    }
}
