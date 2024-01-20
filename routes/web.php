<?php

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// 長くなるので、use文を使って短くする
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

//Route::get('/', [App\Http\Controllers\RecipeController::class, 'index'])->name('recipes.index');
Route::get('/', [RecipeController::class, 'home'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // ログインしているユーザーのみアクセス可能にする
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/recipes/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::patch('/recipes/update/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    // レシピ投稿機能
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipe.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipe.show');

require __DIR__.'/auth.php';
