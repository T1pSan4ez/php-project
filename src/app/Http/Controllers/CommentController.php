<?php

namespace App\Http\Controllers;

use App\validation\CommentValidator;

class CommentController extends Controller
{
    public function addComment()
    {
        if (!$this->getSessionData('user')) {
            $this->redirect('/login');
        }

        $userId = $this->getSessionData('user')['id'];
        $movieId = $_POST['movie_id'];
        $commentText = trim($_POST['comment_text']);

        $validator = new CommentValidator();

        if (!empty($commentText) && $validator->validate($commentText)) {
            $this->db->execute("INSERT INTO comments (user_id, movie_id, comment_text) VALUES (?, ?, ?)", [
                $userId,
                $movieId,
                $commentText,
            ]);

            $this->redirect("/films/{$movieId}");
        } else {
            $error = "Ваш комментарий слишком длинный. Максимальная длина: 512 символов.";
            $this->showFilmPageWithError($movieId, $error);
        }
    }

    public function deleteComment()
    {
        if (!$this->getSessionData('user')) {
            echo "Требуется авторизация.";
            return;
        }

        if (!isset($_POST['comment_id']) || !isset($_POST['movie_id'])) {
            echo "Недопустимые данные.";
            return;
        }

        $userId = $this->getSessionData('user')['id'];
        $adminRole = $this->getSessionData('user')['admin_role'] ?? 0;
        $commentId = (int)$_POST['comment_id'];
        $movieId = (int)$_POST['movie_id'];

        $comment = $this->db->fetch("SELECT user_id FROM comments WHERE id = ?", [$commentId]);

        if (!$comment) {
            echo "Комментарий не найден.";
            return;
        }

        if ($comment['user_id'] !== $userId && $adminRole != 1) {
            echo "У вас нет прав для удаления этого комментария.";
            return;
        }

        $this->db->execute("DELETE FROM comments WHERE id = ?", [$commentId]);

        $this->redirect("/films/{$movieId}");
    }

    public function toggleLikeComment()
    {
        if (!$this->getSessionData('user')) {
            $this->redirect('/login');
        }

        $userId = $this->getSessionData('user')['id'];
        $commentId = $_POST['comment_id'];

        $existingLike = $this->db->fetch("SELECT * FROM comment_likes WHERE comment_id = ? AND user_id = ?", [$commentId, $userId]);

        if ($existingLike) {
            $this->db->execute("DELETE FROM comment_likes WHERE comment_id = ? AND user_id = ?", [$commentId, $userId]);
        } else {
            $this->db->execute("INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)", [$commentId, $userId]);
        }

        $this->redirect("/films/{$_POST['movie_id']}");
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
