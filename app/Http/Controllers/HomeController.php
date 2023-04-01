<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $articles = Article::all();

        foreach ($articles as $article) {
            $article->image = asset('storage/' . ($article->image ? $article->image : 'photo_placement_wide.jpg'));
        }

        return inertia('Home', compact('categories', 'articles'));
    }
}
