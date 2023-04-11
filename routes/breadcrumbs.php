<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use \App\Http\Controllers\CategoryController;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail, String $slug): void {
    $trail->parent('home');

    $trail->push(CategoryController::getCategoryNameBySlug($slug), route('category.index', $slug));
});

Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, String $slug, String $article_slug): void {
    $trail->parent('category.index', $slug);

    $trail->push(CategoryController::getCategoryNameBySlug($article_slug), route('article.show', [$slug, $article_slug]));
});
