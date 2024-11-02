<?php

use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::get('/sign-in', 'showSignIn')->name('show-sign-in')->middleware('guest');
    Route::post('/sign-in', 'signIn')->name('sign-in')->middleware('guest');
    Route::get('/logout', 'logout')->name('logout')->middleware('auth');
});
