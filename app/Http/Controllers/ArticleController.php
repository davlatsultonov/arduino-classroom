<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request)
    {
        $breadcrumbs = Breadcrumbs::render('article.show', $request->slug, $request->article_slug)->getData();
        $article = Article::where('slug', $request->article_slug)->firstOrFail();
        return inertia('Articles/Show', compact('article', 'breadcrumbs'));
    }
}
