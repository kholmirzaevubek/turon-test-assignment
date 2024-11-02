<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::get('/sign-in', 'showSignIn')->name('show-sign-in')->middleware('guest');
    Route::post('/sign-in', 'signIn')->name('sign-in')->middleware('guest');
    Route::get('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'admin'], function () {
    Route::group(['prefix' => 'movies', 'as' => 'movies.', 'controller' => MovieController::class], function () {
        Route::get('/', 'listMovies')->name('list-movies');
        Route::get('/create', 'showCreateFormMovie')->name('show-create-movie');
        Route::post('/create', 'createMovie')->name('create-movie');
    });
});
