<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function show(Request $request)
    {
        $currentTest = Test::whereId($request->test_id)->with('testQuestions.testAnswers')->first();

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
