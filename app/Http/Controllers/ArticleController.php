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
        $article = Article::where('slug', $request->article_slug)->firstOrFail();
        $article->timestamps = false;
        $article->views++;
        $article->save();
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
        return Article::where('views','>', 10)
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('articles.*', 'categories.slug as category_slug', 'categories.name as category_name')
            ->limit(10)->get();
    }

    public static function getReadArticles()
    {
        return auth()->check() ? ArticleRead::query()->where('user_id', auth()->user()->id)->pluck('article_id') : [];
    }
}
