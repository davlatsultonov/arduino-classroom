<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('articles.*', 'categories.name as category_name', 'categories.slug as category_slug')
            ->orderBy('articles.created_at', 'DESC')
            ->get()
            ->groupBy('category_name');


        return inertia('Home', compact('articles'));
    }
}
