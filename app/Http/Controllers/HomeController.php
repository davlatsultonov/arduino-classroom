<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::withWhereHas('category', fn($q) => $q->where('slug', '!=', 'tutorials'))
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy('category.name');

        return inertia('Home', compact('articles'));
    }
}
