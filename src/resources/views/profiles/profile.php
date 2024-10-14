<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабинет пользователя</title>
    <link rel="stylesheet" href="/src/public/styles/movies.css">
</head>
<body>
<h2>Кабинет пользователя</h2>

<div class="profile-info">
    <p><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Имя не задано') ?></p>
    <p><strong>Почта:</strong> <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Почта не задана') ?></p>

    <?php if (!empty($_SESSION['user']['profile_image'])): ?>
        <div>
            <strong>Текущее изображение профиля:</strong>
            <img src="/uploads/<?= htmlspecialchars($_SESSION['user']['profile_image']) ?>" alt="Изображение профиля" width="150">
        </div>
    <?php else: ?>
        <p><strong>Изображение профиля не загружено</strong></p>
    <?php endif; ?>
</div>

<form action="/profile/update" method="POST" enctype="multipart/form-data">
    <div>
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
    </div>

    <div>
        <label for="password">Новый пароль:</label>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <label for="profile_image">Изображение профиля:</label>
        <input type="file" id="profile_image" name="profile_image" accept="image/*">
    </div>

    <button type="submit">Сохранить изменения</button>
</form>

</body>
</html>
