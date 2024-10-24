<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use Faker\Factory;
use App\validation\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLikes = $this->db->fetch("SELECT COUNT(*) as count FROM comment_likes")['count'];
        $totalComments = $this->db->fetch("SELECT COUNT(*) as count FROM comments")['count'];
        $totalMovies = $this->db->fetch("SELECT COUNT(*) as count FROM movies")['count'];
        $totalGenres = $this->db->fetch("SELECT COUNT(*) as count FROM genres")['count'];
        $totalUsers = $this->db->fetch("SELECT COUNT(*) as count FROM users")['count'];

        $data = [
            'title' => 'Панель управления',
            'activePage' => 'dashboard',
            'totalLikes' => $totalLikes,
            'totalComments' => $totalComments,
            'totalMovies' => $totalMovies,
            'totalGenres' => $totalGenres,
            'totalUsers' => $totalUsers
        ];

        extract($data);

        $content = __DIR__ . '/../../../resources/views/admin/dashboard.php';

        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function editMovies()
    {
        $title = 'Редактировать фильмы';
        $activePage = 'movies';

        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($searchQuery)) {
            $movies = $this->db->fetchAll("SELECT * FROM movies WHERE original_title LIKE ? AND release_date IS NOT NULL", ['%' . $searchQuery . '%']);
        } else {
            $movies = $this->db->fetchAll("SELECT * FROM movies WHERE release_date IS NOT NULL");
        }

        $content = __DIR__ . '/../../../resources/views/admin/movies.php';

        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function showEditMovieForm($id)
    {
        $movie = $this->db->fetch("SELECT * FROM movies WHERE id = ?", [$id]);

        if (!$movie) {
            $this->setSessionData('errors', 'Фильм не найден.');
            $this->redirect('/admin-panel/movies');
            return;
        }

        $title = 'Редактировать фильм';
        $activePage = 'movies';

        $content = __DIR__ . '/../../../resources/views/admin/movies/editMovie.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function updateMovie()
    {
        $validator = new Validator();
        $errors = [];

        $id = $_POST['id'];
        $original_title = $_POST['original_title'];
        $title = $_POST['title'];
        $overview = $_POST['overview'];
        $release_date = $_POST['release_date'];
        $vote_average = $_POST['vote_average'];
        $vote_count = $_POST['vote_count'];
        $popularity = $_POST['popularity'];
        $original_language = $_POST['original_language'];
        $video = $_POST['video'];
        $posterFileName = null;

        if (!$validator->validate('original_title', $original_title)) {
            $errors['original_title'] = 'Название (Original Title) должно быть от 3 до 255 символов.';
        }

        if (!$validator->validate('title', $title)) {
            $errors['title'] = 'Название должно быть от 3 до 255 символов.';
        }

        if (!$validator->validate('overview', $overview)) {
            $errors['overview'] = 'Описание должно быть не менее 10 символов.';
        }

        if (!$validator->validate('release_date', $release_date)) {
            $errors['release_date'] = 'Неверный формат даты выхода.';
        }

        if (!$validator->validate('vote_average', $vote_average)) {
            $errors['vote_average'] = 'Рейтинг должен быть от 0 до 10.';
        }

        if (!$validator->validate('vote_count', $vote_count)) {
            $errors['vote_count'] = 'Количество голосов должно быть числом.';
        }

        if (!$validator->validate('popularity', $popularity)) {
            $errors['popularity'] = 'Популярность должна быть числом.';
        }

        if (!$validator->validate('original_language', $original_language)) {
            $errors['original_language'] = 'Оригинальный язык не может быть пустым.';
        }

        if (!empty($errors)) {
            $this->setSessionData('errors', $errors);
            $this->setSessionData('old', $_POST);
            $this->redirect("/admin-panel/edit-movie/$id");
            return;
        }

        if (!empty($_FILES['poster']['name'])) {
            $posterFileName = $this->uploadFile($_FILES['poster'], '/var/www/src/public/uploads/');
            if ($posterFileName) {
                $this->db->execute("UPDATE movies SET poster_path = ? WHERE id = ?", [$posterFileName, $id]);
            } else {
                $errors['poster'] = 'Не удалось загрузить изображение.';
                $this->setSessionData('errors', $errors);
                $this->redirect("/admin-panel/edit-movie/$id");
                return;
            }
        }

        $this->db->execute(
            "UPDATE movies SET original_title = ?, title = ?, overview = ?, release_date = ?, vote_average = ?, vote_count = ?, popularity = ?, original_language = ?, video = ? WHERE id = ?",
            [
                $original_title,
                $title,
                $overview,
                $release_date,
                $vote_average,
                $vote_count,
                $popularity,
                $original_language,
                $video,
                $id
            ]
        );

        $this->redirect('/admin-panel/movies');
    }

    public function showAddMovieForm()
    {
        $title = 'Добавить фильм';
        $activePage = 'add_movie';
        $content = __DIR__ . '/../../../resources/views/admin/movies/addMovie.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function addMovie()
    {
        $validator = new Validator();
        $errors = [];

        $original_title = $_POST['original_title'];
        $title = $_POST['title'];
        $overview = $_POST['overview'];
        $release_date = $_POST['release_date'];
        $vote_average = $_POST['vote_average'];
        $vote_count = $_POST['vote_count'];
        $popularity = $_POST['popularity'];
        $original_language = $_POST['original_language'];
        $posterPath = null;

        if (!$validator->validate('original_title', $original_title)) {
            $errors['original_title'] = 'Название (Original Title) должно быть от 3 до 255 символов.';
        }

        if (!$validator->validate('title', $title)) {
            $errors['title'] = 'Название должно быть от 3 до 255 символов.';
        }

        if (!$validator->validate('overview', $overview)) {
            $errors['overview'] = 'Описание должно быть не менее 10 символов.';
        }

        if (!$validator->validate('release_date', $release_date)) {
            $errors['release_date'] = 'Неверный формат даты выхода.';
        }

        if (!$validator->validate('vote_average', $vote_average)) {
            $errors['vote_average'] = 'Рейтинг должен быть от 0 до 10.';
        }

        if (!$validator->validate('vote_count', $vote_count)) {
            $errors['vote_count'] = 'Количество голосов должно быть числом.';
        }

        if (!$validator->validate('popularity', $popularity)) {
            $errors['popularity'] = 'Популярность должна быть числом.';
        }

        if (!$validator->validate('original_language', $original_language)) {
            $errors['original_language'] = 'Оригинальный язык не может быть пустым.';
        }

        if (!empty($errors)) {
            $this->setSessionData('errors', $errors);
            $this->setSessionData('old', $_POST);
            $this->redirect('/admin-panel/movies/add');
            return;
        }

        if (!empty($_FILES['poster']['name'])) {
            $posterFileName = $this->uploadFile($_FILES['poster'], '/var/www/src/public/uploads/');
            if ($posterFileName) {
                $posterPath = $posterFileName;
            } else {
                $errors['poster'] = 'Не удалось загрузить изображение.';
            }
        }

        $this->db->execute(
            "INSERT INTO movies (original_title, title, overview, release_date, vote_average, vote_count, popularity, original_language, poster_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $original_title,
                $title,
                $overview,
                $release_date,
                $vote_average,
                $vote_count,
                $popularity,
                $original_language,
                $posterPath
            ]
        );

        $this->redirect('/admin-panel/movies');
    }

    public function showDeleteMovieForm()
    {
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($searchQuery)) {
            $movies = $this->db->fetchAll("SELECT * FROM movies WHERE original_title LIKE ?", ['%' . $searchQuery . '%']);
        } else {
            $movies = $this->db->fetchAll("SELECT * FROM movies WHERE release_date IS NOT NULL");
        }

        $title = 'Удалить фильм';
        $activePage = 'delete_movie';
        $content = __DIR__ . '/../../../resources/views/admin/movies/deleteMovie.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function deleteMovie($id)
    {
        $this->db->execute("DELETE FROM movies WHERE id = ?", [$id]);

        $this->redirect('/admin-panel/movies/delete');
    }

    public function showEditGenresForm()
    {
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($searchQuery)) {
            $movies = $this->db->fetchAll("SELECT movies.id, movies.original_title, GROUP_CONCAT(genres.name SEPARATOR '; ') as genres
                             FROM movies
                             LEFT JOIN movie_genre ON movies.id = movie_genre.movie_id
                             LEFT JOIN genres ON movie_genre.genre_id = genres.id
                             WHERE movies.original_title LIKE ?
                             GROUP BY movies.id", ['%' . $searchQuery . '%']);
        } else {
            $movies = [];
        }

        $genres = $this->db->fetchAll("SELECT * FROM genres");

        $title = 'Редактировать жанры фильмов';
        $activePage = 'genres';
        $content = __DIR__ . '/../../../resources/views/admin/movies/editGenres.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function showGenresEditForm($id)
    {
        $movie = $this->db->fetch("SELECT id, original_title FROM movies WHERE id = ?", [$id]);

        if (!$movie) {
            $this->redirect('/admin-panel/movies/genres');
            return;
        }

        $selectedGenres = $this->db->fetchAll("SELECT genre_id FROM movie_genre WHERE movie_id = ?", [$id]);
        $genres = $this->db->fetchAll("SELECT * FROM genres");

        $title = 'Редактировать жанры для фильма: ' . htmlspecialchars($movie['original_title']);
        $activePage = 'genres';
        $content = __DIR__ . '/../../../resources/views/admin/movies/editMovieGenres.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function updateGenres()
    {
        $movieId = $_POST['movie_id'];
        $selectedGenres = isset($_POST['genres']) ? $_POST['genres'] : [];

        $this->db->execute("DELETE FROM movie_genre WHERE movie_id = ?", [$movieId]);

        foreach ($selectedGenres as $genreId) {
            $this->db->execute("INSERT INTO movie_genre (movie_id, genre_id) VALUES (?, ?)", [$movieId, $genreId]);
        }

        $this->redirect('/admin-panel/movies/genres');
    }

    public function addGenre()
    {
        $genreId = $_POST['genre_id'];
        $genreName = trim($_POST['genre_name']);

        $existingGenre = $this->db->fetch("SELECT * FROM genres WHERE id = ? OR name = ?", [$genreId, $genreName]);

        if ($existingGenre) {
            $this->setSessionData('errors', 'Жанр с таким ID или названием уже существует.');
            $this->redirect('/admin-panel/movies/genres');
            return;
        }

        $this->db->execute("INSERT INTO genres (id, name) VALUES (?, ?)", [$genreId, $genreName]);

        $this->setSessionData('success', 'Жанр успешно добавлен.');
        $this->redirect('/admin-panel/movies/genres');
    }

    public function deleteGenres()
    {
        $selectedGenres = isset($_POST['genre']) ? $_POST['genre'] : [];

        if (!empty($selectedGenres)) {
            $genreIds = implode(',', array_fill(0, count($selectedGenres), '?'));
            $this->db->execute("DELETE FROM genres WHERE id IN ($genreIds)", $selectedGenres);
            $this->db->execute("DELETE FROM movie_genre WHERE genre_id IN ($genreIds)", $selectedGenres);

            $this->setSessionData('success', 'Выбранные жанры успешно удалены.');
        } else {
            $this->setSessionData('errors', 'Пожалуйста, выберите жанры для удаления.');
        }

        $this->redirect('/admin-panel/movies/genres');
    }

    public function showUserGenerator()
    {
        $title = 'Генерация пользователей';
        $activePage = 'user_generator';
        $content = __DIR__ . '/../../../resources/views/admin/generateUsers.php';
        include __DIR__ . '/../../../resources/views/layouts/adminLayout.php';
    }

    public function generateRandomUsers()
    {
        $faker = Factory::create();
        $count = $_POST['user_count'] ?? 10;

        for ($i = 0; $i < $count; $i++) {
            $username = $faker->name;
            $email = $faker->unique()->safeEmail;
            $password = password_hash('password', PASSWORD_DEFAULT);
            $birthDate = $faker->date('Y-m-d', '-18 years');
            $gender = $faker->randomElement(['male', 'female', 'another']);

            $emailExists = $this->db->fetch("SELECT COUNT(*) as count FROM users WHERE email = ?", [$email]);

            while ($emailExists['count'] > 0) {
                $email = $faker->unique()->safeEmail;
                $emailExists = $this->db->fetch("SELECT COUNT(*) as count FROM users WHERE email = ?", [$email]);
            }

            $this->db->execute("INSERT INTO users (username, email, password, birthdate, gender, admin_role) VALUES (?, ?, ?, ?, ?, ?)", [
                $username,
                $email,
                $password,
                $birthDate,
                $gender,
                0
            ]);
        }

        $this->setSessionData('success', "$count пользователей успешно сгенерированы!");
        $this->redirect('/admin-panel/users/generate');
    }
}
