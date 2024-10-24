<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/films">Фильмы</a>
        <button class="btn btn-outline-secondary me-3" id="theme-toggle">Темная тема</button>

        <div class="ms-auto d-flex align-items-center">
            <?php if (isset($_SESSION['user'])): ?>
                <?php
                $profileImage = !empty($_SESSION['user']['profile_image']) ? htmlspecialchars($_SESSION['user']['profile_image']) : 'default-profile.jpg';
                ?>
                <img src="/uploads/<?= $profileImage ?>" alt="Profile Image" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                <a class="btn btn-outline-primary me-2" href="/profile">Мой профиль</a>

                <?php if (!empty($_SESSION['user']['admin_role']) && $_SESSION['user']['admin_role'] == 1): ?>
                    <a class="btn btn-outline-warning me-2" href="/admin-panel/dashboard">Администрация</a>
                <?php endif; ?>

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

<script>
    let currentTheme = localStorage.getItem('theme') || 'light';

    document.body.classList.add(currentTheme);
    const themeToggleButton = document.getElementById('theme-toggle');
    themeToggleButton.textContent = currentTheme === 'dark' ? 'На светлую тему' : 'На темную тему';

    themeToggleButton.addEventListener('click', function () {
        if (document.body.classList.contains('light')) {
            document.body.classList.remove('light');
            document.body.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            themeToggleButton.textContent = 'На светлую тему';
        } else {
            document.body.classList.remove('dark');
            document.body.classList.add('light');
            localStorage.setItem('theme', 'light');
            themeToggleButton.textContent = 'На темную тему';
        }
    });
</script>
