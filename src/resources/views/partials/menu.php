<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="/src/public/styles/movies.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="/films">Фильмы</a></li>
        <li><a href="/films">Сериалы</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="/profile">Мой профиль</a></li>
            <li>
                <form action="/logout" method="POST">
                    <button type="submit">Выход</button>
                </form>
            </li>
        <?php else: ?>
            <li><a href="/login">Войти</a></li>
            <li><a href="/register">Регистрация</a></li>
        <?php endif; ?>
    </ul>
</nav>
</body>
</html>