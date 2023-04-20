<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TestController;
use \App\Http\Controllers\ArticleController;
use \App\Http\Controllers\Auth\RegisterController;

Route::prefix('register')
    ->controller(RegisterController::class)
    ->middleware('guest')
    ->name('register.')->group(static function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

Route::controller(LoginController::class)->group(static function () {
    Route::prefix('login')
        ->middleware('guest')
        ->name('login.')->group(function () {
            Route::get('/', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
    Route::delete('logout', 'destroy')->name('logout');
});

Route::prefix('uroki')->group(function () {
    Route::get('/{slug}', function ($slug) {
        return inertia('Tutorial', [
            'currentTutorial' => \App\Models\Article::where('slug', $slug)->first(),
            'tutorials' => \App\Models\Category::firstWhere('slug', 'uroki')->articles
        ]);
    });
    Route::get('/', function () {
        $articleName = \App\Models\Article::where(
            'category_id',
            \App\Models\Category::where('slug', 'uroki')->first()->id
        )->oldest()->first()->slug;

        return redirect('uroki/' . $articleName);
    });
});

Route::middleware(['auth:web'])->group(function () {
    Route::prefix('profile/test')->name('profile.test.')
        ->controller(TestController::class)->group(static function () {
            Route::get('/', 'index')->name('index');
            Route::post('/{id}', 'show')->name('show');
            Route::post('/', 'store')->name('store');
        });
    Route::get('profile', ['App\Http\Controllers\ProfileController', 'index'])->name('profile.index');
});

Route::prefix('{slug}')->group(static function () {
    Route::prefix('{article_slug}')
        ->controller(ArticleController::class)->group(static function () {
            Route::get('', 'show')->name('article.show');
            Route::post('', 'store')->name('article.store')
                ->middleware('auth:web');
        });
    Route::get('/', ['App\Http\Controllers\CategoryController', 'index'])->name('category.index');
});

Route::get('/', ['App\Http\Controllers\HomeController', 'index'])->name('home');
