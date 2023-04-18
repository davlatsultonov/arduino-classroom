<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use \App\Http\Controllers\Controller;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail, String $slug): void {
    $trail->parent('home');

    $trail->push(\App\Services\BaseService::getRecordNameBySlug(\App\Models\Category::class, $slug), route('category.index', $slug));
});

Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, String $slug, String $article_slug): void {
    $trail->parent('category.index', $slug);

    $trail->push(\App\Services\BaseService::getRecordNameBySlug(\App\Models\Article::class, $article_slug), route('article.show', [$slug, $article_slug]));
});
