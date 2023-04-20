<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return inertia('Profile/Testing/TestIndex', [
            'availableCategories' => TestService::getAvailableCategoriesWithTest(),
            'availableTests' => TestService::getAvailableTests()
        ]);
    }

    public function show($test_id)
    {
        $currentTest = Test::whereId($test_id)->with('testQuestions.testAnswers')->first();

        return inertia('Profile/Testing/TestIndex', compact('currentTest'));
    }

    public function store(Request $request)
    {
        foreach ($request->quizResults as $quizResult) {
            TestResult::updateOrCreate(
                [
                    'test_question_id' => $quizResult['test_question_id'],
                    'user_id' => $quizResult['user_id']
                ],
                [
                    'test_answer_id' => $quizResult['test_answer_id']
                ]
            );
        }

        return redirect()->route('profile.test.index');
    }
}
