<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;

class TutorialController extends Controller
{
    public function index()
    {
        $articleName = Article::whereHas('category', fn($q) => $q->whereSlug('uroki'))
            ->first()->slug;

        return to_route('tutorial.show', [$articleName]);
    }

    public function show($slug)
    {
        $currentArticle = Article::where('slug', $slug)
                            ->with('comments', fn($q) => $q->latest())
                            ->first();

        $currentArticle->comments_count = Comment::without(['user', 'replies'])->where('article_id', $currentArticle->id)->get()->count();

        return inertia('Tutorial/Tutorial', [
            'currentTutorial' => $currentArticle,
            'tutorials' => Article::with('sub_category', 'category')
                            ->latest()
                            ->get()
                            ->where('category.slug', 'uroki')
                            ->groupBy('sub_category.name')
        ]);
    }
}
