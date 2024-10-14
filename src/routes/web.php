<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\RMVC\Route\Route;


Route::get('/register', [RegisterController::class, 'index'])->name('register.register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register/{post}', [RegisterController::class, 'show'])->name('register.show');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');



Route::get('/films', [FilmController::class, 'index'])->name('films.index')->middleware('register');
Route::post('/films', [FilmController::class, 'store'])->name('films.store')->middleware('register');
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show')->middleware('register');