<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;
use App\validation\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $activePage = 'dashboard';
        $content = __DIR__ . '/../../../resources/views/admin/dashboard.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function editMovies()
    {
        $title = 'Редактировать фильмы';
        $activePage = 'movies';
        $db = new DB();

        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($searchQuery)) {
            $movies = $db->fetchAll("SELECT * FROM movies WHERE original_title LIKE ? AND release_date IS NOT NULL", ['%' . $searchQuery . '%']);
        } else {
            $movies = $db->fetchAll("SELECT * FROM movies WHERE release_date IS NOT NULL");
        }

        $content = __DIR__ . '/../../../resources/views/admin/movies.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function showEditMovieForm($id)
    {
        $db = new DB();

        $movie = $db->fetch("SELECT * FROM movies WHERE id = ?", [$id]);

        if (!$movie) {
            $_SESSION['errors'] = 'Фильм не найден.';
            Route::redirect('/admin-panel/movies');
            return;
        }

        $title = 'Редактировать фильм';
        $activePage = 'movies';

        $content = __DIR__ . '/../../../resources/views/admin/movies/editMovie.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function updateMovie()
    {
        $db = new DB();

        $id = $_POST['id'];
        $original_title = $_POST['original_title'];
        $overview = $_POST['overview'];
        $release_date = $_POST['release_date'];
        $vote_average = $_POST['vote_average'];
        $video = $_POST['video'];

        if (!empty($_FILES['poster']['name'])) {
            $targetDir = '/var/www/src/public/uploads/';

            $targetFile = $targetDir . basename($_FILES['poster']['name']);

            if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFile)) {
                $db->execute("UPDATE movies SET poster_path = ? WHERE id = ?", [basename($_FILES['poster']['name']), $id]);

            } else {
                $errors['poster'] = 'Не удалось загрузить изображение. Код ошибки: ' . $_FILES['poster']['error'];
            }
        }

        $db->execute("UPDATE movies SET original_title = ?, overview = ?, release_date = ?, vote_average = ?, video = ? WHERE id = ?", [
            $original_title, $overview, $release_date, $vote_average, $video, $id
        ]);
        Route::redirect('/admin-panel/movies');
    }

    public function manageUsers()
    {
        $title = 'Управление пользователями';
        $activePage = 'users';
        $content = __DIR__ . '/../../../resources/views/admin/users.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }
}
