<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRead;
use App\Models\Comment;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Отображает страницу статьи.
     *
     * @param Request $request Запрос HTTP.
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        // TODO исправить отображение хлебных крошек на странице учебника
        // Генерируем данные для хлебных крошек
        $breadcrumbs = Breadcrumbs::render('article.show', $request->slug, $request->article_slug)->getData();

        // Получаем статью по указанному slug
        $article = Article::whereSlug($request->article_slug)
            ->with('comments', fn($q) => $q->latest())
            ->firstOrFail();

        // Получаем количество комментариев для статьи
        $article->comments_count = Comment::without(['user', 'replies'])->where('article_id', $article->id)->get()->count();

        // Отключаем автоматическое обновление временных меток
        $article->timestamps = false;

        // Увеличиваем счетчик просмотров статьи
        $article->increment('views');

        // Возвращаем отклик с использованием Inertia.js и переданными данными
        return inertia('Articles/Show', compact('article', 'breadcrumbs'));
    }

    /**
     * Сохраняет информацию о прочтении статьи.
     *
     * @param Request $request Запрос HTTP.
     * @return void
     */
    public function store(Request $request)
    {
        // Создаем или обновляем запись о прочтении статьи
        ArticleRead::query()->updateOrCreate([
            'article_id' => $request->id,
            'user_id' => auth()->user()->id,
        ]);
    }

}
