<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class FilmController extends Controller
{
    public function index($page = 1)
    {
        $searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
        $selectedGenres = isset($_GET['genre']) ? (array)$_GET['genre'] : [];
        $sortOrder = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

        $page = isset($_GET['page']) ? (int)$_GET['page'] : $page;
        if ($page < 1) {
            $page = 1;
        }

        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $db = new DB();
        $genres = $this->getGenres($db);

        $films = $this->getFilms($db, $searchQuery, $selectedGenres, $sortOrder, $offset, $perPage);

        $totalFilms = $this->getTotalFilms($db, $searchQuery, $selectedGenres);
        $totalPages = ceil($totalFilms / $perPage);

        if ($totalFilms == 0) {
            $totalPages = 0;
        }

        $content = __DIR__ . '/../../../resources/views/film/index.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
    }

    private function getFilms(DB $db, $searchQuery, $selectedGenres, $sortOrder, $offset, $perPage)
    {
        $sql = "SELECT movies.* FROM movies";

        if (!empty($selectedGenres)) {
            $genrePlaceholders = implode(',', array_fill(0, count($selectedGenres), '?'));
            $sql .= " INNER JOIN movie_genre ON movies.id = movie_genre.movie_id 
                  WHERE movie_genre.genre_id IN ($genrePlaceholders)
                  AND release_date IS NOT NULL 
                  AND vote_count >= 50";
            $params = $selectedGenres;

            $sql .= " GROUP BY movies.id 
                  HAVING COUNT(DISTINCT movie_genre.genre_id) = " . count($selectedGenres);
        } else {
            $sql .= " WHERE release_date IS NOT NULL 
                  AND vote_count >= 50";
            $params = [];
        }

        if (!empty($searchQuery)) {
            $sql .= " AND original_title LIKE ?";
            $params[] = '%' . $searchQuery . '%';
        }

        if (!empty($sortOrder) && in_array($sortOrder, ['asc', 'desc'])) {
            $sql .= " ORDER BY vote_average " . strtoupper($sortOrder);
        }

        $sql .= " LIMIT $perPage OFFSET $offset";

        return $db->fetchAll($sql, $params);
    }

    private function getTotalFilms(DB $db, $searchQuery, $selectedGenres)
    {
        $sql = "SELECT COUNT(DISTINCT movies.id) as total FROM movies";

        if (!empty($selectedGenres)) {
            $genrePlaceholders = implode(',', array_fill(0, count($selectedGenres), '?'));
            $sql .= " INNER JOIN movie_genre ON movies.id = movie_genre.movie_id 
                  WHERE movie_genre.genre_id IN ($genrePlaceholders)
                  AND release_date IS NOT NULL 
                  AND vote_count >= 50";
            $params = $selectedGenres;

            $sql .= " GROUP BY movies.id 
                  HAVING COUNT(DISTINCT movie_genre.genre_id) = " . count($selectedGenres);
        } else {
            $sql .= " WHERE release_date IS NOT NULL 
                  AND vote_count >= 50";
            $params = [];
        }

        if (!empty($searchQuery)) {
            $sql .= " AND original_title LIKE ?";
            $params[] = '%' . $searchQuery . '%';
        }

        $result = $db->fetchAll($sql, $params);

        return (!empty($selectedGenres)) ? count($result) : (isset($result[0]['total']) ? $result[0]['total'] : 0);
    }

    private function getGenres(DB $db)
    {
        return $db->fetchAll("SELECT id, name FROM genres");
    }

    public function show($id)
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $commentsPerPage = 5;
        $offset = ($currentPage - 1) * $commentsPerPage;

        $film = $this->getFilmById($id);

        if (!$film) {

            Route::redirect('/error');
            exit();
        }

        $genres = $this->getGenresByFilmId($id);
        $totalComments = $this->getTotalCommentsByFilmId($id);
        $comments = $this->getCommentsByFilmId($id, $commentsPerPage, $offset);

        $ratingController = new RatingController();
        $averageRating = $ratingController->getAverageRating($id);

        $movieId = $id;

        $userRating = null;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $userRating = $ratingController->getUserRating($id, $userId);
        }

        $totalPages = ceil($totalComments / $commentsPerPage);

        $content = __DIR__ . '/../../../resources/views/film/show.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
    }

    public function getCommentsByFilmId($id, $limit = 5, $offset = 0)
    {
        $db = new DB();
        $sql = "
    SELECT comments.id, comments.user_id, comments.comment_text, comments.created_at, comments.user_avatar, users.username
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE comments.movie_id = ?
    ORDER BY comments.created_at DESC
    LIMIT $limit OFFSET $offset
    ";
        return $db->fetchAll($sql, [$id]);
    }

    public function getFilmById($id)
    {
        $db = new DB();
        return $db->fetch("SELECT * FROM movies WHERE id = ?", [$id]);
    }

    public function getGenresByFilmId($id)
    {
        $db = new DB();

        $sql = "
        SELECT genres.name 
        FROM genres 
        INNER JOIN movie_genre ON genres.id = movie_genre.genre_id 
        WHERE movie_genre.movie_id = ?
    ";
        return $db->fetchAll($sql, [$id]);
    }

    public function getTotalCommentsByFilmId($id)
    {
        $db = new DB();
        $sql = "SELECT COUNT(*) as total_comments FROM comments WHERE movie_id = ?";
        $result = $db->fetch($sql, [$id]);
        return $result['total_comments'] ?? 0;
    }

}
