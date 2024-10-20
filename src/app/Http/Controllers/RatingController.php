<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;

class RatingController extends Controller
{
    public function rateMovie()
    {
        if (!isset($_SESSION['user'])) {
            Route::redirect('/login');
            exit();
        }



        $userId = $_SESSION['user']['id'];
        $movieId = (int)$_POST['movie_id'];
        $rating = (int)$_POST['rating'];

        if ($rating < 1 || $rating > 10) {
            echo "Некорректная оценка.";
            return;
        }

        $db = new DB();

        $existingRating = $db->fetch("SELECT id FROM ratings WHERE user_id = ? AND movie_id = ?", [$userId, $movieId]);

        if ($existingRating) {
            $db->execute("UPDATE ratings SET rating = ? WHERE id = ?", [$rating, $existingRating['id']]);
        } else {
            $db->execute("INSERT INTO ratings (user_id, movie_id, rating) VALUES (?, ?, ?)", [$userId, $movieId, $rating]);
        }

        Route::redirect("/films/{$movieId}");
    }

    public function getAverageRating($movieId)
    {
        $db = new DB();
        $result = $db->fetch("SELECT AVG(rating) AS average_rating FROM ratings WHERE movie_id = ?", [$movieId]);

        return $result ? $result['average_rating'] : null;
    }

    public function getUserRating($movieId, $userId)
    {
        $db = new DB();
        $result = $db->fetch("SELECT rating FROM ratings WHERE movie_id = ? AND user_id = ?", [$movieId, $userId]);

        return $result ? $result['rating'] : null;
    }
}
