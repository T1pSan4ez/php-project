<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View;

class AuthController extends Controller
{
    public function index()
    {

        return View::view('auth.index');
    }

    public function show($post)
    {
        return View::view('auth.show', compact('post'));
    }


    public function store()
    {
        $errors = [];

        if (empty($_POST['username'])) {
            $errors[] = 'Имя пользователя обязательно.';
        }

        if (empty($_POST['email'])) {
            $errors[] = 'Электронная почта обязательна.';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Неверный формат электронной почты.';
        }

        if (empty($_POST['password'])) {
            $errors[] = 'Пароль обязателен.';
        } elseif (strlen($_POST['password']) < 6) {
            $errors[] = 'Пароль должен содержать не менее 6 символов.';
        }

        // Если есть ошибки, возвращаем на страницу регистрации с сообщениями
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            Route::redirect('/auth');
            return; // Завершаем выполнение метода, чтобы не продолжать дальше
        }

        // Хешируем пароль
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Создаем нового пользователя в базе данных
        $db = new \App\RMVC\Database\DB('mysql', 'palmo', 'palmo', 'palmo');
        $db->execute("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [
            $_POST['username'],
            $_POST['email'],
            $hashedPassword,
        ]);

        $_SESSION['message'] = 'Регистрация успешна!';
        Route::redirect('/auth');
    }


}