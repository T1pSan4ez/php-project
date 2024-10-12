<?php

namespace App\Http\Controllers;
class Controller
{
//    public function fetchMovies($page = 1)
//    {
//        $apiKey = '0099006263f714dc2164a25ebd2cbce3';
//        $baseUrl = 'https://api.themoviedb.org/3/discover/movie';
//
//        // Параметры запроса
//        $params = [
//            'include_adult' => 'false',
//            'include_video' => 'false',
//            'language' => 'en-US',
//            'page' => $page, // Используем переданную страницу
//            'sort_by' => 'popularity.desc',
//            'api_key' => $apiKey
//        ];
//
//        // Преобразование параметров в строку запроса
//        $queryParams = http_build_query($params);
//
//        // Полный URL для запроса
//        $url = $baseUrl . '?' . $queryParams; // Здесь формируем полный URL
//
//        // Инициализация cURL
//        $ch = curl_init();
//
//        // Настройка параметров cURL
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        // Выполнение запроса
//        $response = curl_exec($ch);
//
//        // Проверка на ошибки
//        if (curl_errno($ch)) {
//            echo 'Ошибка запроса API: ' . curl_error($ch);
//            curl_close($ch);
//            return null;
//        }
//
//        // Закрытие cURL
//        curl_close($ch);
//
//        // Возвращаем ответ в виде массива
//        return json_decode($response, true);
//    }
//
//    public function fetchAllPages($maxPages = 90) {
//        $allMovies = [];
//
//        // Цикл по страницам
//        for ($page = 1; $page <= $maxPages; $page++) {
//            echo "Получение данных со страницы: $page\n";
//            $data = $this->fetchMovies($page);
//
//            if ($data && isset($data['results'])) {
//                // Добавляем данные фильмов в общий массив
//                $allMovies = array_merge($allMovies, $data['results']);
//            } else {
//                echo "Ошибка при получении данных с страницы: $page\n";
//            }
//
//            // Небольшая задержка между запросами, чтобы не перегружать сервер API
//            //sleep(1);
//        }
//
//        return $allMovies;
//    }


}