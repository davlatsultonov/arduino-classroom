<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TestController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'categories' => fn () => Category::all(),
            'topArticles' => fn() => ArticleController::getTopArticles(),
            'availableTestCategories' => fn () => TestController::getAvailableTestCategories(),
            'auth' => function () {
                return [
                    'user' => Auth::user(),
                    'check' => Auth::check(),
                    'solved_tests' =>  Auth::check() ? TestController::getUserTestCategories(Auth::user()->id) : [],
                    'read_articles' => ArticleController::getReadArticles()
                ];
            },
        ]);
    }
}
