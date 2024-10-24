<?php

namespace App\Http\Controllers;

use App\RMVC\View\View;
use App\validation\Validator;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Логин';
        $content = __DIR__ . '/../../../resources/views/login/index.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
    }

    public function login()
    {
        $errors = [];
        $validator = new Validator();

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
            $this->setSessionData('errors', $errors);
            $this->setSessionData('form_data', $_POST);
            $this->redirect('/login');
        }

        $user = $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
        if ($user && password_verify($password, $user['password'])) {
            $this->setSessionData('user', [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['username'],
                'profile_image' => $user['profile_image'] ?? 'default-profile.jpg',
                'admin_role' => $user['admin_role']
            ]);

            if ($remember_me) {
                $token = bin2hex(random_bytes(16));
                setcookie('remember_me', $token, time() + (86400 * 30), "/", "", false, true);
                $this->db->execute("UPDATE users SET remember_token = ? WHERE id = ?", [$token, $user['id']]);
            }

            $this->redirect('/films');
        } else {
            $this->setSessionData('errors', ['email' => 'Неверные данные для входа.']);
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        if ($this->getSessionData('user')) {
            $userId = $this->getSessionData('user')['id'];
            $this->db->execute("UPDATE users SET remember_token = NULL WHERE id = ?", [$userId]);

            setcookie('remember_me', '', time() - 3600, "/", "", false, true);
            session_destroy();
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
