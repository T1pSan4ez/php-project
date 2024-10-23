<?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['errors']) ?>
        <?php unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="mb-3">
    <form action="/admin-panel/movies/genres/add" method="POST" class="d-flex">
        <input style="width: 300px;" type="text" name="genre_name" class="form-control me-2" placeholder="Введите название нового жанра" required>
        <input style="width: 100px;" type="number" name="genre_id" class="form-control me-2" placeholder="ID жанра" required>
        <button type="submit" class="btn btn-success">Добавить жанр</button>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="/admin-panel/movies/genres" method="GET" class="d-flex">
        <input style="width: 250px;" type="text" name="search" class="form-control me-2" placeholder="Введите название фильма" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="btn btn-primary">Поиск</button>
    </form>
</div>

<?php if (!empty($movies)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th style="width: 450px;">Название</th>
            <th>Жанры</th>
            <th style="width: 150px;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($movies as $movie): ?>
            <tr>
                <td><?= htmlspecialchars($movie['id'] ?? '') ?></td>
                <td><?= htmlspecialchars($movie['original_title'] ?? '') ?></td>
                <td><?= htmlspecialchars($movie['genres'] ?? '') ?></td>
                <td>
                    <a href="/admin-panel/movies/genres/edit/<?= htmlspecialchars($movie['id']) ?>" class="btn btn-primary">Изменить жанры</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <?php if (!empty($searchQuery)): ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            <strong>Упс!</strong> Фильмы не найдены по вашему запросу. Попробуйте изменить фильтры или поиск.
        </div>
    <?php endif; ?>
<?php endif; ?>
