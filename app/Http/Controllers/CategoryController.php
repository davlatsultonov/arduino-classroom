<?php

namespace App\Http\Controllers;


use App\Models\Article;
use Diglactic\Breadcrumbs\Breadcrumbs;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $breadcrumbs = Breadcrumbs::render('category.index', $slug)->getData();
        $articles = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereSlug($slug))
            ->get();

        return inertia('Articles/Index', compact('articles', 'breadcrumbs'));
    }
}
