<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Отображает страницу регистрации.
     *
     * @return \Inertia\Response - ответ Inertia с данными о странице регистрации
     */
    public function create()
    {
        return inertia('Auth/Register');
    }

    /**
     * Обрабатывает запрос на регистрацию.
     *
     * @param \Illuminate\Http\Request $request - HTTP-запрос
     * @return \Illuminate\Http\RedirectResponse - перенаправление после успешной регистрации
     */
    public function store(RegisterRequest $request)
    {
        // Создание нового пользователя с использованием валидированных данных из запроса и хэшированным паролем
        User::create(array_merge($request->validated(), ['password' => Hash::make($request->password)]));

        // Аутентификация пользователя после регистрации
        Auth::attempt($request->validated(), true);

        $request->session()->regenerate();

        return redirect()->route('profile.index');
    }
}
