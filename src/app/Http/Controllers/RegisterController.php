<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;
use App\validation\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return View::view('register.index');
    }

    public function show($post)
    {
        return View::view('register.show', compact('post'));
    }

    public function store()
    {
        $errors = [];
        $validator = new Validator();
        $db = new DB('mysql', 'palmo', 'palmo', 'palmo');


        if (!$validator->validate('username', $_POST['username'])) {
            $errors['username'] = 'Имя пользователя обязательно.';
        }

        if (!$validator->validate('email', $_POST['email'])) {
            $errors['email'] = 'Неверный формат электронной почты.';
        } else {
            $existingUser = $db->fetch("SELECT * FROM users WHERE email = ?", [$_POST['email']]);
            if ($existingUser) {
                $errors['email'] = 'Пользователь с таким адресом электронной почты уже существует.';
            }
        }

        if (!$validator->validate('password', $_POST['password'])) {
            $errors['password'] = 'Пароль должен содержать не менее 6 символов.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            Route::redirect('/register');
            return;
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $db->execute("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [
            $_POST['username'],
            $_POST['email'],
            $hashedPassword,
        ]);

        $_SESSION['message'] = 'Регистрация успешна!';
        Route::redirect('/register');
    }
}