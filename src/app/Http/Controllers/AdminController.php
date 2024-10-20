<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;
use App\validation\Validator;

class AdminController extends Controller
{
    public function edit()
    {
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
            $errors['username'] = 'Имя пользователя должно содержать не менее 3 символов.';
        }

        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $errors['profile_image'] = 'Ошибка загрузки файла. Код ошибки: ' . $_FILES['profile_image']['error'];
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            Route::redirect('/profile');
            return;
        }

        $name = htmlspecialchars($_POST['name']);
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $db->execute("UPDATE users SET username = ? WHERE id = ?", [$name, $userId]);

        if ($password) {
            $db->execute("UPDATE users SET password = ? WHERE id = ?", [$password, $userId]);
        }

        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = __DIR__ . '/../../../public/uploads/';

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetFile = $targetDir . basename($_FILES['profile_image']['name']);

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $db->execute("UPDATE users SET profile_image = ? WHERE id = ?", [basename($_FILES['profile_image']['name']), $userId]);
            } else {
                $errors['profile_image'] = 'Не удалось загрузить изображение. Код ошибки: ' . $_FILES['profile_image']['error'];
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            Route::redirect('/profile');
            return;
        }

        $_SESSION['message'] = 'Изменения успешно сохранены!';
        Route::redirect('/profile');
    }

}
