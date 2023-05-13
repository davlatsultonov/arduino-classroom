<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRead;
use App\Models\Comment;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request)
    {
        // TODO fix breadcrumbs appearance in tutorial page
        $breadcrumbs = Breadcrumbs::render('article.show', $request->slug, $request->article_slug)->getData();

        $article = Article::whereSlug($request->article_slug)
            ->with('comments', fn($q) => $q->latest())
            ->firstOrFail();

        $article->comments_count = Comment::without(['user', 'replies'])->where('article_id', $article->id)->get()->count();
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
}
