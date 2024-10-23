<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="/admin-panel/movies" method="GET" class="d-flex">
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
                <a href="/admin-panel/edit-movie/<?= $movie['id'] ?>" class="btn btn-primary">Редактировать</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>