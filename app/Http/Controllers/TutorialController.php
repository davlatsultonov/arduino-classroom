<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\SubCategory;

class TutorialController extends Controller
{
    /**
     * Отображает страницу списка учебных материалов.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse - перенаправление на страницу учебного материала
     */
    public function index()
    {
        $articleSlug = SubCategory::orderBy('order')->withWhereHas('articles', fn($q) => $q->orderByOrder())->firstOrFail()->articles->firstOrFail()->slug;

        return to_route('tutorials.show', [$articleSlug]);
    }

    /**
     * Отображает страницу учебного материала.
     *
     * @param string $slug - слаг учебного материала
     * @return \Inertia\Response - ответ Inertia с данными о текущем учебном материале
     */
    public function show($slug)
    {
        $currentTutorial = Article::where('slug', $slug)
            ->with(['comments' => fn($q) => $q->latest(), 'sub_category'])
            ->firstOrFail();

        $currentTutorial->comments_count = Comment::without(['user', 'replies'])->where('article_id', $currentTutorial->id)->get()->count();

        return inertia('Tutorial/Tutorial', compact('currentTutorial'));
    }
}
