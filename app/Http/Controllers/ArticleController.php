<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request)
    {
        $article = Article::where('slug', $request->article_slug)->firstOrFail();

        return inertia('Articles/Show', compact('article'));
    }
}
