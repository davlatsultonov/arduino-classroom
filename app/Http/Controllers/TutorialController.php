<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
class TutorialController extends Controller
{
    public function index()
    {
        $articleName = Article::whereHas('category', fn($q) => $q->whereSlug('uroki'))
            ->first()->slug;

        return to_route('tutorial.show', [$articleName]);
    }

    public function show($slug)
    {
        return inertia('Tutorial', [
            'currentTutorial' => Article::where('slug', $slug)->first(),
            'tutorials' => Category::firstWhere('slug', 'uroki')->articles
        ]);
    }
}
