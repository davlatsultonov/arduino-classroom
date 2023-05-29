<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;

class ProfileController extends Controller
{
    /**
     * Отображает страницу профиля пользователя.
     */
    public function index()
    {
        // Получение имени пользователя через глобальный хелпер \Auth
        $name = \Auth::user()->name;

        // Получение общего количества очков пользователя через метод из сервиса ProfileService
        $totalPointsCount = ProfileService::getTotalPointsCount();

        // Получение текущего количества очков пользователя через метод из сервиса ProfileService
        $currentPointsCount = ProfileService::getCurrentPointsCount();

        // Отображение страницы профиля пользователя с передачей данных
        return inertia('Profile/Index', [
            'name' => $name,
            'totalPointsCount' => $totalPointsCount,
            'currentPointsCount' => $currentPointsCount
        ]);
    }

}
