<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\AuthController;
use App\RMVC\Route\Route;


Route::get('/auth', [AuthController::class, 'index'])->name('auth.index')->middleware('auth');
Route::post('/auth', [AuthController::class, 'store'])->name('auth.store')->middleware('auth');
Route::get('/auth/{post}/', [AuthController::class, 'show'])->name('auth.show')->middleware('auth');

Route::get('/films', [FilmController::class, 'index'])->name('films.index')->middleware('auth');
Route::post('/films', [FilmController::class, 'store'])->name('films.store')->middleware('auth');
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show')->middleware('auth');