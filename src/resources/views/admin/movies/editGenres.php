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
    <h5>Добавить жанр</h5>
    <form action="/admin-panel/movies/genres/add" method="POST" class="d-flex">
        <input style="width: 300px;" type="text" name="genre_name" class="form-control me-2" placeholder="Введите название нового жанра" required>
        <input style="width: 100px;" type="number" name="genre_id" class="form-control me-2" placeholder="ID жанра" required>
        <button type="submit" class="btn btn-success">Добавить жанр</button>
    </form>
</div>

<?php if (!empty($genres)): ?>
    <div>
        <h5>Удалить жанры</h5>
        <form id="deleteGenresForm" method="POST" action="/admin-panel/movies/genres/delete" class="d-flex justify-content-between align-items-center">
            <div class="d-flex flex-wrap">
                <?php foreach ($genres as $genre): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="genre_<?= $genre['id'] ?>" name="genre[]" value="<?= htmlspecialchars($genre['id']) ?>">
                        <label class="form-check-label" for="genre_<?= $genre['id'] ?>">
                            <?= htmlspecialchars($genre['name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="width: 500px;">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Удалить выбранные жанры</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы уверены, что хотите удалить выбранные жанры? Это действие необратимо.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteGenresForm').submit();">Удалить</button>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <p>Нет доступных жанров для отображения.</p>
<?php endif; ?>

<h5>Поиск фильмов</h5>
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

