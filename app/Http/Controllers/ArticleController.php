<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRead;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request)
    {
        $breadcrumbs = Breadcrumbs::render('article.show', $request->slug, $request->article_slug)->getData();
        $article = Article::whereSlug($request->article_slug)->firstOrFail();
        $article->timestamps = false;
        $article->increment('views');
        return inertia('Articles/Show', compact('article', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        ArticleRead::query()->updateOrCreate([
            'article_id' => $request->id,
            'user_id' => auth()->user()->id,
        ]);
    }

    public static function getTopArticles()
    {
        return Article::popular()
            ->with('category')
            ->take(10)
            ->orderBy('views', 'desc')
            ->get();
    }

    public static function getReadArticles()
    {
        return ArticleRead::where('user_id', auth()->user()->id)->pluck('article_id');
    }
}
