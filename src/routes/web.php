<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Error404Controller;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\RMVC\Route\Route;

Route::get('/register', [RegisterController::class, 'index'])->name('register.register')->middleware('GuestMiddleware');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register/{post}', [RegisterController::class, 'show'])->name('register.show');

Route::get('/login', [LoginController::class, 'index'])->name('login.index')->middleware('GuestMiddleware');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('AuthMiddleware');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

Route::get('/films', [FilmController::class, 'index']);
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
Route::post('/films', [FilmController::class, 'store'])->name('films.store');

Route::post('/add-comment', [CommentController::class, 'addComment']);
Route::post('/delete-comment', [CommentController::class, 'deleteComment']);
Route::post('/rate-movie', [RatingController::class, 'rateMovie']);

Route::get('/error', [Error404Controller::class, 'notFound'])->name('error.notFound');