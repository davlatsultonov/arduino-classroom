<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

class TestService extends Facade
{
    /**
     * Получает доступные категории с тестами.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция доступных категорий с тестами
     */
    public static function getAvailableCategoriesWithTest()
    {
        return SubCategory::has('tests')->get();
    }

    /**
     * Получает доступные тесты.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция доступных тестов
     */
    public static function getAvailableTests()
    {
        return Test::has('testQuestions')->has('testAnswers')->get();
    }

    /**
     * Получает категории тестов пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция категорий тестов пользователя
     */
    public static function getUserTestCategories()
    {
        return Category::hasCompletedTests()->get();
    }
}

