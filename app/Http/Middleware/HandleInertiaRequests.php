<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ArticleController;
use App\Models\Category;
use App\Services\ArticleService;
use App\Services\TestService;
use Illuminate\Http\Request;
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
           'shared' => [
               'categories' => fn () => Category::whereHas('articles')->get(),
               'tutorials' => fn() => ArticleService::getTutorialPageArticles(),
               'auth' => fn() => auth()->check() ? [
                   'userId' => auth()->id(),
                   'userName' => auth()->user()->name,
                   'solved_tests' =>  TestService::getUserTestCategories(),
                   'read_articles' => ArticleService::getReadArticles()
               ] : null,
           ]
        ]);
    }
}
