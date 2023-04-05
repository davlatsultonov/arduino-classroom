<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProfileController;

// Profile
Route::controller(ProfileController::class)->group(static function () {
    Route::get('/profile', 'index')->name('profile.index')->middleware('auth:sanctum');
});
// Auth
Route::controller(LoginController::class)->group(static function () {
    Route::get('/login', 'create')->name('login')->middleware('guest');
    Route::post('/login', 'store')->middleware('guest');
    Route::delete('/logout', 'destroy')->name('logout');
});
Route::get('/{slug}/{article_slug}', ['App\Http\Controllers\ArticleController', 'show'])->name('article.show');
Route::get('/{slug}', ['App\Http\Controllers\CategoryController', 'index'])->name('category.index');
Route::get('/', ['App\Http\Controllers\HomeController', 'index'])->name('home');

