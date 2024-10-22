<form action="/admin-panel/movies/update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id'] ?? '') ?>">

    <div class="mb-3">
        <label for="original_title" class="form-label">Название</label>
        <input type="text" class="form-control" id="original_title" name="original_title" value="<?= htmlspecialchars($movie['original_title'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="overview" class="form-label">Описание</label>
        <textarea class="form-control" id="overview" name="overview" rows="3"><?= htmlspecialchars($movie['overview'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="release_date" class="form-label">Дата выхода</label>
        <input type="date" class="form-control" id="release_date" name="release_date" value="<?= htmlspecialchars($movie['release_date'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="vote_average" class="form-label">Рейтинг</label>
        <input type="number" step="0.1" class="form-control" id="vote_average" name="vote_average" value="<?= htmlspecialchars($movie['vote_average'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="video" class="form-label">Ссылка на видео</label>
        <input type="text" class="form-control" id="video" name="video" value="<?= htmlspecialchars($movie['video'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="poster" class="form-label">Постер фильма</label>
        <input type="file" class="form-control" id="poster" name="poster">
    </div>

    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>
