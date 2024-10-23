<form action="/admin-panel/movies/genres/update" method="POST">
    <input type="hidden" name="movie_id" value="<?= htmlspecialchars($movie['id']) ?>">

    <div class="mb-3">
        <?php foreach ($genres as $genre): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="<?= htmlspecialchars($genre['id']) ?>"
                    <?= in_array(['genre_id' => $genre['id']], $selectedGenres) ? 'checked' : '' ?>>
                <label class="form-check-label"><?= htmlspecialchars($genre['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>
