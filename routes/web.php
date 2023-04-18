<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TestController;
use \App\Http\Controllers\Auth\RegisterController;

Route::middleware(['auth:web'])->group(function () {
    Route::controller(TestController::class)->group(static function () {
        Route::get('/profile/test', 'index')->name('profile.test.index');
        Route::post('/profile/test/{id}', 'show')->name('profile.test.show');
        Route::post('/profile/test', 'store')->name('profile.test.store');
    });
    Route::get('/profile', ['App\Http\Controllers\ProfileController', 'index'])->name('profile.index');
    Route::post('/{slug}/{article_slug}', ['App\Http\Controllers\ArticleController', 'store']);
});
// Auth
Route::controller(RegisterController::class)->group(static function () {
    Route::get('/register', 'create')->name('register')->middleware('guest');
    Route::post('/register', 'store')->middleware('guest');
});
Route::controller(LoginController::class)->group(static function () {
    Route::get('/login', 'create')->name('login')->middleware('guest');
    Route::post('/login', 'store')->middleware('guest');
    Route::delete('/logout', 'destroy')->name('logout');
});
Route::get('/uroki/{slug}', function ($slug) {
    return inertia('Tutorial', [
        'currentTutorial' => \App\Models\Article::where('slug', $slug)->first(),
        'tutorials' => \App\Models\Category::firstWhere('slug', 'uroki')->articles
    ]);
});
Route::get('/uroki', function () {
    $articleName = \App\Models\Article::where(
        'category_id',
        \App\Models\Category::where('slug', 'uroki')->first()->id
    )->oldest()->first()->slug;

    return redirect('/uroki/' . $articleName);
});
Route::get('/{slug}/{article_slug}', ['App\Http\Controllers\ArticleController', 'show'])->name('article.show');
Route::get('/{slug}', ['App\Http\Controllers\CategoryController', 'index'])->name('category.index');
Route::get('/', ['App\Http\Controllers\HomeController', 'index'])->name('home');

