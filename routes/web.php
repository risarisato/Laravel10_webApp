<?php

// 長くなるので、use文を使って短くする
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;



//Route::get('/', [App\Http\Controllers\RecipeController::class, 'index'])->name('recipes.index');
Route::get('/', [RecipeController::class, 'home'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ログインしているユーザーのみアクセス可能にする
Route::middleware('auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // レシピの編集
    Route::get('/recipes/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::patch('/recipes/update/{id}', [RecipeController::class, 'update'])->name('recipe.update');

    // レシピの削除
    Route::delete('/recipes/delete/{id}', [RecipeController::class, 'destroy'])->name('recipe.destroy');

    // レビューの投稿機能
    Route::post('/recipes/{id}/review', [ReviewController::class, 'store'])->name('review.store');

    // レシピの登録
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipe.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipe.show');

require __DIR__.'/auth.php';
