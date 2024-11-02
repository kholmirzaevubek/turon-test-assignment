<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\MovieController;
use App\Http\Controllers\MovieController as ClientMovieController;
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
        Route::get('/update/{movieId}', 'showUpdateFormMovie')->name('show-update-movie');
        Route::post('/update/{movieId}', 'updateMovie')->name('update-movie');
        Route::get('/delete/{movieId}', 'deleteMovie')->name('delete-movie');
        Route::get('/{movieId}', 'getSpecificMovie')->name('specific-movie');
    });

    Route::group(['prefix' => 'genres', 'as' => 'genres.', 'controller' => GenreController::class], function () {
        Route::get('/', 'listGenres')->name('list-genres');
        Route::get('/create', 'showCreateGenre')->name('show-create-genre');
        Route::post('/create', 'createGenre')->name('create-genre');
        Route::get('/update/{genreId}', 'showUpdateGenre')->name('show-update-genre');
        Route::post('/update/{genreId}', 'updateGenre')->name('update-genre');
        Route::get('/delete/{genreId}', 'deleteGenre')->name('delete-genre');
    });
});

Route::group(['prefix' => '/', 'as' => 'home.', 'controller' => ClientMovieController::class], function () {
    Route::get('/', 'listMovies');
    Route::get('/{movieId}', 'getSpecificMovie')->name('get-specific-movie');
});
