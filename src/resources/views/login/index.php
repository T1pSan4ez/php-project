<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/validator.css">
    <title>Логин</title>
</head>
<body>
<h2>Логин</h2>

<form action="/login" method="post">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>">
        <?php if (!empty($_SESSION['errors']['email'])): ?>
            <span class="error"><?= htmlspecialchars($_SESSION['errors']['email']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" >
        <?php if (!empty($_SESSION['errors']['password'])): ?>
            <span class="error"><?= htmlspecialchars($_SESSION['errors']['password']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="remember_me">
            <input type="checkbox" id="remember_me" name="remember_me"> Запомнить меня
        </label>
    </div>

    <div>
        <button type="submit">Вход</button>
    </div>
</form>

<div>
    <a href="/register">
        <button>Регистрация</button>
    </a>
</div>


<?php unset($_SESSION['errors']); unset($_SESSION['form_data']); ?>

</body>
</html>
