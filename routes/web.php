<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\TestController;
use \App\Http\Controllers\ArticleController;
use \App\Http\Controllers\TutorialController;
use \App\Http\Controllers\Auth\RegisterController;

Route::prefix('comments')
    ->group(static function () {
        Route::redirect('/', '/');
        Route::post('/', [CommentController::class, 'store'])->name('comment.store');
    });

Route::prefix('register')
    ->controller(RegisterController::class)
    ->middleware('guest')
    ->name('register.')
    ->group(static function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

Route::controller(LoginController::class)->group(static function () {
    Route::prefix('login')->name('login.')->middleware('guest')->group(static function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });
    Route::delete('logout', 'destroy')->name('logout');
});

Route::prefix('tutorials')
    ->name('tutorials.')
    ->controller(TutorialController::class)->group(static function () {
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/', 'index')->name('index');
    });

Route::middleware(['auth:web'])
    ->prefix('profile')
    ->name('profile.')
    ->group(static function () {
        Route::prefix('test')
            ->name('test.')
            ->controller(TestController::class)->group(static function () {
                Route::inertia('/', 'Profile/Testing/TestIndex')->name('index');
                Route::post('/{id}', 'show')->name('show');
                Route::post('/', 'store')->name('store');
            });
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });

Route::prefix('{slug}')->group(static function () {
    Route::prefix('{article_slug}')
        ->controller(ArticleController::class)
        ->group(static function () {
            Route::get('', 'show')->name('article.show');
            Route::post('', 'store')->name('article.store')->middleware('auth:web');
        });
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
