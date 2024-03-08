<?php

use App\Http\Controllers\CategoryController;
use App\Livewire\Home;
use App\Livewire\UserArticles;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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

Route::get('/', Home::class)->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Route::get('/dashboard', function () {
    //    return view('dashboard');
    //})->name('dashboard');
    Route::get('articles', UserArticles::class)->name('dashboard');
    Route::resource('categories', CategoryController::class)->except('show');
});
Route::get('articles/{article}', function(Article $article){
    return view('articles.show', compact('article'));
})->name('articles.show');