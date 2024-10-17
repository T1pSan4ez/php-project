<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/films">Фильмы</a>
        <a class="navbar-brand" href="/series">Сериалы</a>

        <div class="ms-auto d-flex align-items-center">
            <?php if (isset($_SESSION['user'])): ?>
                <a class="btn btn-outline-primary me-2" href="/profile">Мой профиль</a>
                <form action="/logout" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-outline-danger">Выход</button>
                </form>
            <?php else: ?>
                <a class="btn btn-outline-primary me-2" href="/login">Войти</a>
                <a class="btn btn-outline-secondary" href="/register">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
