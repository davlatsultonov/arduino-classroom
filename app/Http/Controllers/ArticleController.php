<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $article->image = asset('storage/', $article->image);
        return inertia('Articles/Index', compact('article'));
    }
}
