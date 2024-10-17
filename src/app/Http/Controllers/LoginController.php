<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;
use App\validation\Validator;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Логин';
        $content = __DIR__ . '/../../../resources/views/login/index.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
        //return View::view('login.index');
    }

    public function login()
    {
        $errors = [];
        $validator = new Validator();
        $db = new DB('mysql', 'palmo', 'palmo', 'palmo');

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $remember_me = isset($_POST['remember_me']) ? true : false;

        if (!$validator->validate('email', $email)) {
            $errors['email'] = 'Email обязательный.';
        }

        if (!$validator->validate('password', $password)) {
            $errors['password'] = 'Пароль обязательный.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            Route::redirect('/login');
            return;
        }

        $user = $db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['username'],
            ];

            if ($remember_me) {
                $token = bin2hex(random_bytes(16));
                setcookie('remember_me', $token, time() + (86400 * 30), "/", "", false, true);
                $db->execute("UPDATE users SET remember_token = ? WHERE id = ?", [$token, $user['id']]);
            }

            Route::redirect('/films');
        } else {
            $_SESSION['errors'] = ['email' => 'Неверные данные для входа.'];
            Route::redirect('/login');
        }
    }


    public function logout()
    {

        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $db = new DB('mysql', 'palmo', 'palmo', 'palmo');
            $db->execute("UPDATE users SET remember_token = NULL WHERE id = ?", [$userId]);

            setcookie('remember_me', '', time() - 3600, "/", "", false, true);

            session_destroy();
        }

        Route::redirect('/login');
    }
}
