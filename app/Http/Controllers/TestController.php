<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function show(Request $request)
    {
        $test_id = $request->test_id;

        if ($test_id === '*') {
            $currentTest = Test::whereId(1)->with('subCategory')->first();

            $currentTest->test_questions = TestQuestion::with('testAnswers')
                ->whereHas('test', fn($q) => $q->where('sub_category_id', $request->sub_category_id))
                ->get()->shuffle();
        } else {
            $currentTest = Test::whereId($test_id)->with('testQuestions.testAnswers', 'subCategory')->first();
        }

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
