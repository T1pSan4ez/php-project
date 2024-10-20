<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;
use App\validation\CommentValidator;

class CommentController extends Controller
{
    public function addComment()
    {
        if (!isset($_SESSION['user'])) {
            Route::redirect('/login');
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $movieId = $_POST['movie_id'];
        $userAvatar = $_SESSION['user']['profile_image'];
        $commentText = trim($_POST['comment_text']);

        $validator = new CommentValidator();

        if (!empty($commentText) && $validator->validate($commentText)) {
            $db = new DB();
            $db->execute("INSERT INTO comments (user_id, movie_id, comment_text, user_avatar) VALUES (?, ?, ?, ?)", [
                $userId,
                $movieId,
                $commentText,
                $userAvatar
            ]);

            Route::redirect("/films/{$movieId}");
        }else {
            $error = "Ваш комментарий слишком длинный. Максимальная длина: 512 символов.";
            $this->showFilmPageWithError($movieId, $error);
        }
    }

    public function deleteComment()
    {
        if (!isset($_SESSION['user'])) {
            echo "Требуется авторизация.";
            return;
        }

        if (!isset($_POST['comment_id']) || !isset($_POST['movie_id'])) {
            echo "Недопустимые данные.";
            return;
        }

        $userId = $_SESSION['user']['id'];
        $adminRole = $_SESSION['user']['admin_role'] ?? 0;
        $commentId = (int)$_POST['comment_id'];
        $movieId = (int)$_POST['movie_id'];

        $db = new DB();
        $comment = $db->fetch("SELECT user_id FROM comments WHERE id = ?", [$commentId]);

        if (!$comment) {
            echo "Комментарий не найден.";
            return;
        }

        if ($comment['user_id'] !== $userId && $adminRole != 1) {
            echo "У вас нет прав для удаления этого комментария.";
            return;
        }

        $db->execute("DELETE FROM comments WHERE id = ?", [$commentId]);

        Route::redirect("/films/{$movieId}");
    }

    private function showFilmPageWithError($movieId, $error)
    {
        $filmController = new FilmController();

        $film = $filmController->getFilmById($movieId);
        $genres = $filmController->getGenresByFilmId($movieId);
        $comments = $filmController->getCommentsByFilmId($movieId);

        $content = __DIR__ . '/../../../resources/views/film/show.php';
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
    }
}