<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Админ-панель' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar .active {
            background-color: #007bff;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .navbar {
            height: 60px;
            background-color: #f8f9fa;
            padding: 0 20px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .admin-info img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #007bff;
            margin-right: 10px;
        }

        .admin-info span {
            font-size: 1.2rem;
            font-weight: bold;
            color: #f8f9fa;
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="text-center mb-1">
        <h3>Админ-панель</h3>
    </div>
    <?php
    $profileImage = !empty($_SESSION['user']['profile_image']) ? htmlspecialchars($_SESSION['user']['profile_image']) : 'default-profile.jpg';
    $adminName = !empty($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'admin';
    ?>
    <div class="admin-info">
        <img src="/uploads/<?= $profileImage ?>" class="rounded-circle" alt="Profile Image">
        <span><?= $adminName ?></span>
    </div>

    <a href="/admin-panel/dashboard" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
    <a href="/" class="nav-link">Добавить фильм</a>
    <a href="/admin-panel/movies" class="nav-link <?= $activePage === 'movies' ? 'active' : '' ?>">Редактировать фильмы</a>
    <a href="/" class="nav-link">Удалить фильм</a>
    <a href="/admin-panel/users" class="nav-link <?= $activePage === 'users' ? 'active' : '' ?>">Управление пользователями</a>
</nav>

<div class="main-content">
    <div class="navbar d-flex justify-content-between align-items-center">
        <h5><?= $title ?? '' ?></h5>
        <div class="d-flex align-items-center">
            <a href="/films" class="btn btn-outline-primary me-2">Фильмы</a>
            <a href="/profile" class="btn btn-outline-warning me-2">Мой профиль</a>
            <form action="/logout" method="POST">
                <button type="submit" class="btn btn-outline-danger">Выход</button>
            </form>
        </div>
    </div>

    <div class="content-wrapper">
        <?php include $content; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
