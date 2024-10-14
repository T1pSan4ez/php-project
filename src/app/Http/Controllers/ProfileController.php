<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class ProfileController extends Controller
{
    public function edit()
    {
        return View::view('profiles.profile');
    }

    public function updateProfile()
    {
        $db = new DB('mysql', 'palmo', 'palmo', 'palmo');
        $userId = $_SESSION['user']['id'];

        $name = htmlspecialchars($_POST['name']);
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $db->execute("UPDATE users SET username = ? WHERE id = ?", [$name, $userId]);

        if ($password) {
            $db->execute("UPDATE users SET password = ? WHERE id = ?", [$password, $userId]);
        }

        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = __DIR__ . '/../../../public/uploads/';
            $fileName = basename($_FILES['profile_image']['name']);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
                $db->execute("UPDATE users SET profile_image = ? WHERE id = ?", [$fileName, $userId]);
            } else {
                $_SESSION['errors'] = ['file' => 'Ошибка загрузки файла.'];
            }
        }

        $_SESSION['message'] = 'Изменения успешно сохранены!';
        Route::redirect('/profile');
    }
}
