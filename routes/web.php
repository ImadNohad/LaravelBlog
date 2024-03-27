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
Route::post('/article/{article}', [ArticleController::class, "storeComment"])->name("addComment");
Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "authenticate"])->name("authenticate");
Route::get('/logout', [AuthController::class, "logout"]);
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class, "store"])->name("storeUser");

Route::middleware('auth')->prefix('admin')->group(function () {
    //Admin Routes
    Route::middleware('admin')->group(function () {
        Route::resource('/categories', CategorieController::class);
        Route::resource('/articles', ArticleController::class);
        Route::resource('/tags', TagController::class);
        Route::resource('/users', UserController::class);
        Route::post('/articles/comments/{comment}', [CommentaireController::class, "accept"])->name("acceptComment");
        Route::delete('/articles/comments/{comment}', [CommentaireController::class, "destroy"])->name("deleteComment");
        Route::get('/articles/comments/', [CommentaireController::class, "index"])->name("comments");
    });

    //Auteur Routes
    Route::middleware('auteur')->group(function () {
        Route::resource('/categories', CategorieController::class);
        Route::resource('/articles', ArticleController::class);
        Route::post('/articles/comments/{comment}', [CommentaireController::class, "accept"])->name("acceptComment");
        Route::delete('/articles/comments/{comment}', [CommentaireController::class, "destroy"])->name("deleteComment");
        Route::get('/articles/comments/', [CommentaireController::class, "index"])->name("comments");
        Route::resource('/tags', TagController::class);
    });
});