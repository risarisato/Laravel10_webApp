<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('breadcrumbsのHomeでパンくずリスト', route('home'));
});

// Home > レシピ一覧
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('レシピ一覧', route('recipe.index'));
});

// Home > レシピ一覧 > レシピ名
Breadcrumbs::for('show', function (BreadcrumbTrail $trail, $recipe) {
    $trail->parent('index');
    $trail->push($recipe['title'], route('recipe.show', $recipe['id']));
});

// Home > レシピ一覧 > レシピ名 > レビュー投稿
Breadcrumbs::for('create', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('レシピ投稿', route('recipe.create'));
});

// Home > レシピ一覧 > レシピ名 > レビュー投稿 > レビュー投稿完了
Breadcrumbs::for('edit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('レシピ編集');

});