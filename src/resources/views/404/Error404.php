<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Страница не найдена</title>
    <!-- Подключение Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .error-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-home {
            padding: 0.75rem 1.5rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
<div class="error-container text-center">
    <h1>404</h1>
    <p>К сожалению, запрашиваемая страница не найдена.</p>
    <a href="/films" class="btn btn-primary btn-home">Вернуться на главную</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
