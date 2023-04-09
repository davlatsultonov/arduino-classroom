<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;

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

        $tests = $this->getTestItems($request);

        return inertia('Profile/Testing/TestIndex', compact('tests'));
    }

    public function store()
    {

    }

    private function getTestItems($request) {
        return Test::where('category_id', '=', $request->category_id)->join('test_questions', 'tests.id', '=', 'test_questions.test_id')
            ->join('test_answers', 'test_questions.id', '=', 'test_answers.test_question_id')
            ->select(
                'test_questions.question',
                'test_answers.answer',
                'test_answers.is_correct',
            )
            ->get();
    }

    public static function getAvailableTestCategories()
    {
        return Test::join('categories', 'tests.category_id', '=', 'categories.id')
            ->distinct()
            ->select('categories.*')
            ->get()
            ->filter(function ($category) {
                return count($category->testQuestions);
            });
    }
}
