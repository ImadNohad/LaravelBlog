<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, "index"])->name("home");
Route::get('/search', [ArticleController::class, "searchArticles"])->name("search");

Route::get('/article/{article}', [ArticleController::class, "show"])->name("article.show");
Route::post('/article/{article}', [ArticleController::class, "storeComment"])->middleware('auth')->name("addComment");

Route::get('/login', [AuthController::class, "login"])->middleware("guest")->name("login");
Route::post('/login', [AuthController::class, "authenticate"])->middleware("guest")->name("authenticate");
Route::get('/register', [AuthController::class, "register"])->middleware("guest")->name("register");
Route::post('/register', [AuthController::class, "store"])->middleware("guest")->name("storeUser");
Route::get('/logout', [AuthController::class, "logout"]);

Route::middleware('auth')->prefix('admin')->group(function () {

    //Admin Routes
    Route::middleware('admin')->group(function () {
        Route::resource('/users', UserController::class);
    });

    //Auteur Routes
    Route::middleware('admin')->middleware('auteur')->group(function () {
        Route::resource('/categories', CategorieController::class);
        Route::resource('/articles', ArticleController::class);
        Route::get('/articles', [ArticleController::class, 'indexAdmin'])->name('articles.index');
        Route::put('/articles/comments/{comment}', [CommentaireController::class, "acceptComment"])->name("acceptComment");
        Route::delete('/articles/comments/{comment}', [CommentaireController::class, "destroy"])->name("deleteComment");
        Route::get('/comments', [CommentaireController::class, "index"])->name("comments");
        Route::resource('/tags', TagController::class);
        Route::resource('articles.comments', CommentaireController::class);
        Route::get('/articles/{article}/comments', [CommentaireController::class, "articleComments"])->name("articleComments");
    });
});