<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;
use App\validation\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $db = new DB('mysql', 'palmo', 'palmo', 'palmo');
        $userId = $_SESSION['user']['id'];

        $user = $db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['username'],
            'email' => $user['email'],
            'profile_image' => $user['profile_image'],
            'admin_role' => $user['admin_role']
        ];

        $title = 'Профиль';
        $content = __DIR__ . '/../../../resources/views/profiles/profile.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
    }

    public function updateProfile()
    {
        $errors = [];
        $validator = new Validator();
        $db = new DB('mysql', 'palmo', 'palmo', 'palmo');
        $userId = $_SESSION['user']['id'];

        if (!$validator->validate('username', $_POST['name'])) {
            if (strlen($_POST['name']) > 32) {
                $errors['username'] = 'Имя пользователя не должно превышать 32 символов.';
            } else {
                $errors['username'] = 'Имя пользователя должно содержать не менее 3 символов.';
            }
        }

        if (!empty($_POST['password'])) {
            if (!$validator->validate('password', $_POST['password'])) {
                if (strlen($_POST['password']) > 32) {
                    $errors['password'] = 'Пароль не должен превышать 32 символов.';
                } else {
                    $errors['password'] = 'Пароль должен содержать не менее 6 символов.';
                }
            }
        }

        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
                $errors['profile_image'] = 'Ошибка загрузки файла. Код ошибки: ' . $_FILES['profile_image']['error'];
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            Route::redirect('/profile');
            return;
        }

        $name = htmlspecialchars($_POST['name']);
        $db->execute("UPDATE users SET username = ? WHERE id = ?", [$name, $userId]);

        if (!empty($_POST['password'])) {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $db->execute("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $userId]);
        }

        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = '/var/www/src/public/uploads/';

            $targetFile = $targetDir . basename($_FILES['profile_image']['name']);

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $db->execute("UPDATE users SET profile_image = ? WHERE id = ?", [basename($_FILES['profile_image']['name']), $userId]);

                $_SESSION['user']['profile_image'] = basename($_FILES['profile_image']['name']);
            } else {
                $errors['profile_image'] = 'Не удалось загрузить изображение. Код ошибки: ' . $_FILES['profile_image']['error'];
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            Route::redirect('/profile');
            return;
        }

        $_SESSION['user']['name'] = $name;

        $_SESSION['message'] = 'Изменения успешно сохранены!';
        Route::redirect('/profile');
    }
}
