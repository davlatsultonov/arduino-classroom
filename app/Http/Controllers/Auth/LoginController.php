<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Отображает страницу входа в систему.
     *
     * @return \Inertia\Response - ответ Inertia с данными о странице входа в систему
     */
    public function create()
    {
        return inertia('Auth/Login');
    }

    /**
     * Обрабатывает запрос на аутентификацию.
     *
     * @param \Illuminate\Http\Request $request - HTTP-запрос
     * @return \Illuminate\Http\RedirectResponse - перенаправление после успешной аутентификации
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('profile.index');
    }

    /**
     * Завершает аутентифицированную сессию.
     *
     * @param \Illuminate\Http\Request $request - HTTP-запрос
     * @return \Illuminate\Http\RedirectResponse - перенаправление на страницу входа после выхода из системы
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.create');
    }
}
