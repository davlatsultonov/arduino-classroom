<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('articles.*', 'categories.slug as category_slug')
            ->get();

        return inertia('Home', compact('articles'));
    }
}
