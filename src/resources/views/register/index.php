<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/validator.css">
    <title>Регистрация</title>
</head>
<body>
<h2>Регистрация</h2>

<form action="/register" method="post">
    <div class="form-group">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username"
               class="<?= !empty($_SESSION['errors']['username']) ? 'input-error' : '' ?>"
               value="<?= htmlspecialchars($_SESSION['form_data']['username'] ?? '') ?>">
        <?php if (!empty($_SESSION['errors']['username'])): ?>
            <span class="error"><?= htmlspecialchars($_SESSION['errors']['username']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               class="<?= !empty($_SESSION['errors']['email']) ? 'input-error' : '' ?>"
               value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>">
        <?php if (!empty($_SESSION['errors']['email'])): ?>
            <span class="error"><?= htmlspecialchars($_SESSION['errors']['email']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password"
               class="<?= !empty($_SESSION['errors']['password']) ? 'input-error' : '' ?>">
        <?php if (!empty($_SESSION['errors']['password'])): ?>
            <span class="error"><?= htmlspecialchars($_SESSION['errors']['password']) ?></span>
        <?php endif; ?>
    </div>

    <div>
        <button type="submit">Зарегистрироваться</button>
    </div>
</form>

<div>
    <a href="/login">
        <button>Логин</button>
    </a>
</div>

<?php unset($_SESSION['errors']); unset($_SESSION['form_data']); ?>

</body>
</html>
