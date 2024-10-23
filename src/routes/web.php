<?php

use App\Http\Controllers\AdminController;
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

Route::post('/comments/like', [CommentController::class, 'toggleLikeComment'])
    ->name('comments.like')
    ->middleware('AuthMiddleware');

Route::get('/error', [Error404Controller::class, 'notFound'])->name('error.notFound');

Route::get('/admin-panel', [AdminController::class, 'panel'])
    ->name('admin.profile')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/movies', [AdminController::class, 'editMovies'])
    ->name('admin.movies')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/edit-movie/{id}', [AdminController::class, 'showEditMovieForm'])
    ->name('admin.movies.edit')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/movies/add', [AdminController::class, 'showAddMovieForm'])
    ->name('admin.movies.add.form')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::post('/admin-panel/movies/add', [AdminController::class, 'addMovie'])
    ->name('admin.movies.add')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/movies/delete', [AdminController::class, 'showDeleteMovieForm'])
    ->name('admin.movies.delete.form')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::post('/admin-panel/movies/delete/{id}', [AdminController::class, 'deleteMovie'])
    ->name('admin.movies.delete')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/movies/genres', [AdminController::class, 'showEditGenresForm'])
    ->name('admin.movies.genres.edit')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/movies/genres/edit/{id}', [AdminController::class, 'showGenresEditForm'])
    ->name('admin.movies.genres.edit.form')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::post('/admin-panel/movies/genres/update', [AdminController::class, 'updateGenres'])
    ->name('admin.movies.genres.update')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::post('/admin-panel/movies/genres/add', [AdminController::class, 'addGenre'])
    ->name('admin.movies.genres.add')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::post('/admin-panel/movies/update', [AdminController::class, 'updateMovie'])
    ->name('admin.movies.update')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

Route::get('/admin-panel/users', [AdminController::class, 'manageUsers'])
    ->name('admin.users')
    ->middleware('AuthMiddleware')
    ->middleware('AdminMiddleware');

