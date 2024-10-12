<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View;
use DateTime;
use PDO;


class FilmController extends Controller
{
    public function index()
    {
        return View::view('film.index');
    }

    public function show($id)
    {
        return View::view('film.show', compact('id'));
    }

    public function store()
    {

        $_SESSION['message'] = $_POST['title'];
        Route::redirect('/posts');
    }
}