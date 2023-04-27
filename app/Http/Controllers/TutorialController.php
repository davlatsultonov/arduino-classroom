<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        return inertia('Tutorial/Tutorial', [
            'currentTutorial' => Article::where('slug', $slug)->first(),
            'tutorials' => Article::with('sub_category', 'category')
                            ->latest()
                            ->get()
                            ->where('category.slug', 'uroki')
                            ->groupBy('sub_category.name')
        ]);
    }
}