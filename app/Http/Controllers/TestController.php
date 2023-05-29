<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Отображает страницу с информацией о тесте.
     *
     * @param Request $request - объект запроса
     * @return \Inertia\Response - ответ Inertia с данными о текущем тесте
     */
    public function show(Request $request)
    {
        $test_id = $request->test_id;

        if ($test_id === '*') {
            // Если идентификатор теста является '*', выбираем первый тест с указанной подкатегорией
            $currentTest = Test::whereId(1)->with('subCategory')->first();

            $currentTest->test_questions = TestQuestion::with('testAnswers')
                ->whereHas('test', fn($q) => $q->where('sub_category_id', $request->sub_category_id))
                ->get()->shuffle();
        } else {
            // Иначе выбираем тест по указанному идентификатору
            $currentTest = Test::whereId($test_id)->with('testQuestions.testAnswers', 'subCategory')->first();
        }

        return inertia('Profile/Testing/TestIndex', compact('currentTest'));
    }
    /**
     * Сохраняет результаты теста.
     *
     * @param Request $request - объект запроса
     * @return \Illuminate\Http\RedirectResponse - перенаправление на страницу списка тестов
     */
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
