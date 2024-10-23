<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="/admin-panel/movies/delete" method="GET" class="d-flex">
        <input style="width: 250px;" type="text" name="search" class="form-control me-2" placeholder="Введите название фильма" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="btn btn-primary">Поиск</button>
    </form>
</div>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th style="width: 300px;">Название</th>
        <th>Описание</th>
        <th style="width: 150px;">Дата выхода</th>
        <th>Рейтинг</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($movies)): ?>
        <?php foreach ($movies as $movie): ?>
            <tr>
                <td><?= htmlspecialchars($movie['id']) ?></td>
                <td><?= htmlspecialchars($movie['original_title']) ?></td>
                <td>
                    <?= mb_strlen($movie['overview']) > 20 ? mb_substr($movie['overview'], 0, 80) . '...' : htmlspecialchars($movie['overview']); ?>
                </td>
                <td style="white-space: nowrap;"><?= htmlspecialchars($movie['release_date']) ?></td>
                <td><?= number_format((float)$movie['vote_average'], 2); ?></td>
                <td>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $movie['id'] ?>">
                        Удалить
                    </button>
                </td>
            </tr>

            <div class="modal fade" id="deleteModal<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $movie['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?= $movie['id'] ?>">Подтверждение удаления</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        </div>
                        <div class="modal-body">
                            Вы уверены, что хотите удалить фильм "<?= htmlspecialchars($movie['original_title']) ?>"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <form action="/admin-panel/movies/delete/<?= $movie['id'] ?>" method="POST" style="display:inline;">
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center">Фильмы не найдены</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
