<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        return inertia('Profile/Testing/TestIndex');
    }

    public function show(Request $request)
    {
        $request->validate([
            'category_id' => 'required'
        ]);

        $tests = $this->getTestItems($request->category_id);

        return inertia('Profile/Testing/TestIndex', compact('tests'));
    }

    public function store(Request $request)
    {
        foreach ($request->quizResults as $quizResult) {
            TestResult::updateOrCreate(
                ['test_question_id' => $quizResult['test_question_id'], 'user_id' => $quizResult['user_id']],
                [
                    'test_answer_id' => $quizResult['test_answer_id']
                ]
            );
        }

        return redirect()->route('profile.test.index');
    }

    private function getTestItems($category_id) {
        return Test::where('category_id', '=', $category_id)->join('test_questions', 'tests.id', '=', 'test_questions.test_id')
            ->join('test_answers', 'test_questions.id', '=', 'test_answers.test_question_id')
            ->select(
                'test_questions.id as test_question_id',
                'test_questions.question',
                'test_answers.id as test_answer_id',
                'test_answers.answer',
                'test_answers.is_correct',
            )
            ->get();
    }

    public static function getAvailableTestCategories()
    {
        return Test::all()->filter(function ($test) {
            return count($test->testQuestions);
        })->map(function ($test) {
            return $test->category;
        });
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
