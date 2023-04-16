<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        return inertia('Profile/Testing/TestIndex', [
            'availableCategories' => self::getAvailableCategoriesWithTest(),
            'availableTests' => self::getAvailableTests()
        ]);
    }

    public function show(Request $request)
    {
        return inertia('Profile/Testing/TestIndex', [
            'currentTest' => $this->getTestItems($request->test_id)
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->quizResults as $quizResult) {
            TestResult::updateOrCreate(
                ['test_question_id' => $quizResult['test_question_id'], 'user_id' => $quizResult['user_id']],
                ['test_answer_id' => $quizResult['test_answer_id']]
            );
        }

        return redirect()->route('profile.test.index');
    }

    private function getTestItems($test_id) {
        return Test::join('test_questions', 'tests.id', '=', 'test_questions.test_id')
            ->join('test_answers', 'test_questions.id', '=', 'test_answers.test_question_id')
            ->select(
                'test_questions.id as test_question_id',
                'test_questions.question',
                'test_answers.id as test_answer_id',
                'test_answers.answer',
                'test_answers.is_correct',
            )
            ->where('tests.id', $test_id)
            ->get();
    }

    public static function getAvailableCategoriesWithTest()
    {
        return Category::withCount('tests')->get()->where('tests_count', '>', 0)->values();
    }

    public static function getAvailableTests()
    {
        return Test::withCount(['testAnswers', 'testQuestions'])->get()
            ->where('test_answers_count', '>', 0)
            ->where('test_questions_count', '>', 0)
            ->values();

    }

    public static function getUserTestCategories()
    {
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
