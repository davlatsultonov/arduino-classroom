<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Сохраняет новый комментарий, отправленный пользователем.
     *
     * @param \Illuminate\Http\Request $request Запрос с данными комментария.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'body' => 'required',
        ]);
        // Получение всех входящих данных
        $input = $request->all();
        // Добавление идентификатора пользователя к данным комментария
        $input['user_id'] = auth()->user()->id;
        // Создание нового комментария
        Comment::create($input);
        // Возвращение пользователя на предыдущую страницу
        return back();
    }
}
