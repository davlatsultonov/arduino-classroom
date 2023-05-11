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
    public static function getAvailableCategoriesWithTest()
    {
        return SubCategory::has('tests')->get();
    }

    public static function getAvailableTests()
    {
        return Test::has('testQuestions')->has('testAnswers')->get();
    }

    public static function getUserTestCategories()
    {
        return Category::hasCompletedTests()->get();

        return Auth::check() ? TestResult::where('user_id', Auth::user()->id)
            ->join('test_questions', 'test_results.test_question_id', 'test_questions.id')
            ->join('tests', 'test_questions.test_id', 'tests.id')
            ->join('categories', 'tests.category_id', 'categories.id')
            ->distinct()
            ->select('categories.name', 'categories.image')
            ->get()
            ->map(function ($category) {
                return $category;
            }) : [];
    }
}

