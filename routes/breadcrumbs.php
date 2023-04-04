<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use \App\Models\Category;


Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail, String $slug): void {
    $trail->parent('home');

    $trail->push($slug, route('category.index', $slug));
});

Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, String $slug, String $article_slug): void {
    $trail->parent('category.index', $slug);

    $trail->push($article_slug, route('article.show', [$slug, $article_slug]));
});
