<?php

namespace App\Http\Controllers;
use App\RMVC\Database\DB;
use App\RMVC\Route\Route;

abstract class Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    protected function redirect($url)
    {
        Route::redirect($url);
        exit();
    }

    protected function setSessionData($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    protected function getSessionData($key)
    {
        return $_SESSION[$key] ?? null;
    }

    protected function uploadFile($file, $targetDir)
    {
        $fileName = basename($file['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        } else {
            return false;
        }
    }
}