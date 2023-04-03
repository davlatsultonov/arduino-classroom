<?php

namespace App\Http\Controllers;


use App\Models\Article;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $articles = Article::join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('articles.*', 'categories.slug as category_slug', 'categories.name as category_name')
            ->where('categories.slug', $slug)->get();

        return inertia('Articles/Index', compact('articles'));
    }
}
