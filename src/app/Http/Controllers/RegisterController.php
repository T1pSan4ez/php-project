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
        $title = 'Регистрация';
        $content = __DIR__ . '/../../../resources/views/register/index.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
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
            if (strlen($_POST['username']) > 32) {
                $errors['username'] = 'Имя пользователя не должно превышать 32 символов.';
            } else {
                $errors['username'] = 'Имя пользователя обязательно.';
            }
        }

        if (!$validator->validate('password', $_POST['password'])) {
            if (strlen($_POST['password']) > 32) {
                $errors['password'] = 'Пароль не должен превышать 32 символов.';
            } else {
                $errors['password'] = 'Пароль должен содержать не менее 6 символов.';
            }
        }

        if (!$validator->validate('email', $_POST['email'])) {
            if (strlen($_POST['email']) > 32) {
                $errors['email'] = 'Email не должен превышать 32 символов.';
            } else {
                $errors['email'] = 'Неверный формат электронной почты.';
            }
        }

        if (empty($_POST['birthdate']) || !$validator->validate('birthdate', $_POST['birthdate'])) {
            $errors['birthdate'] = 'Дата рождения обязательна и должна быть корректной.';
        }

        if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female'])) {
            $errors['gender'] = 'Пол обязателен. Выберите мужской или женский пол.';
        }

        if (!empty($_POST['rating']) && !$validator->validate('preferred_rating', $_POST['rating'])) {
            $errors['preferred_rating'] = 'Предпочтительный рейтинг должен быть числом от 1.0 до 10.0.';
        }

        $preferred_rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? (float) $_POST['rating'] : null;


        if (isset($_FILES['profile_image']) && !$validator->validate('profile_image', $_FILES['profile_image'])) {
            $errors['profile_image'] = 'Ошибка загрузки изображения профиля. Проверьте файл.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            Route::redirect('/register');
            return;
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $profileImagePath = null;
        if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {
            $targetDir = '/var/www/src/public/uploads/';
            $targetFile = $targetDir . basename($_FILES['profile_image']['name']);
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $profileImagePath = '/uploads/' . basename($_FILES['profile_image']['name']);
            } else {
                $_SESSION['errors']['profile_image'] = 'Не удалось загрузить изображение. Код ошибки: ' . $_FILES['profile_image']['error'];
            }
        }

        $countries = isset($_POST['countries']) ? json_encode($_POST['countries']) : json_encode([]);

        $birthdate = $_POST['birthdate'];

        $notifications = isset($_POST['notifications']) ? json_encode($_POST['notifications']) : json_encode([]);

        $db->execute("INSERT INTO users (username, email, password, countries, preferred_rating, birthdate, gender, notifications, profile_image, admin_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $_POST['username'],
            $_POST['email'],
            $hashedPassword,
            $countries,
            $preferred_rating,
            $birthdate,
            $_POST['gender'],
            $notifications,
            $profileImagePath,
            0
        ]);

        $_SESSION['success'] = 'Регистрация успешна! Пожалуйста, войдите в свой аккаунт.';
        Route::redirect('/register');
    }
}
