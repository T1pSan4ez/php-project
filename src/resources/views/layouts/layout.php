<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <title><?= $title ?? 'Мій сайт' ?></title>
</head>
<body>

<?php include __DIR__ . '/../partials/menu.php'; ?>

<div class="content">
    <?php include $filmContent; ?>
</div>

</body>
</html>