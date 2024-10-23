<?php
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
?>

<form action="/admin-panel/movies/add" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="original_title" class="form-label">Название (Original Title)</label>
        <input type="text" class="form-control <?= isset($errors['original_title']) ? 'is-invalid' : '' ?>" id="original_title" name="original_title" required value="<?= htmlspecialchars($old['original_title'] ?? '') ?>">
        <?php if (isset($errors['original_title'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['original_title']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Название</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" required value="<?= htmlspecialchars($old['title'] ?? '') ?>">
        <?php if (isset($errors['title'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['title']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="overview" class="form-label">Описание</label>
        <textarea class="form-control <?= isset($errors['overview']) ? 'is-invalid' : '' ?>" id="overview" name="overview" rows="3" required><?= htmlspecialchars($old['overview'] ?? '') ?></textarea>
        <?php if (isset($errors['overview'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['overview']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="release_date" class="form-label">Дата выхода</label>
        <input type="date" class="form-control <?= isset($errors['release_date']) ? 'is-invalid' : '' ?>" id="release_date" name="release_date" required value="<?= htmlspecialchars($old['release_date'] ?? '') ?>">
        <?php if (isset($errors['release_date'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['release_date']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="vote_average" class="form-label">Рейтинг</label>
        <input type="number" step="0.1" class="form-control <?= isset($errors['vote_average']) ? 'is-invalid' : '' ?>" id="vote_average" name="vote_average" required value="<?= htmlspecialchars($old['vote_average'] ?? '') ?>">
        <?php if (isset($errors['vote_average'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['vote_average']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="vote_count" class="form-label">Количество голосов</label>
        <input type="number" class="form-control <?= isset($errors['vote_count']) ? 'is-invalid' : '' ?>" id="vote_count" name="vote_count" required value="<?= htmlspecialchars($old['vote_count'] ?? '') ?>">
        <?php if (isset($errors['vote_count'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['vote_count']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="popularity" class="form-label">Популярность</label>
        <input type="number" step="0.1" class="form-control <?= isset($errors['popularity']) ? 'is-invalid' : '' ?>" id="popularity" name="popularity" required value="<?= htmlspecialchars($old['popularity'] ?? '') ?>">
        <?php if (isset($errors['popularity'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['popularity']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="original_language" class="form-label">Оригинальный язык</label>
        <input type="text" class="form-control <?= isset($errors['original_language']) ? 'is-invalid' : '' ?>" id="original_language" name="original_language" required value="<?= htmlspecialchars($old['original_language'] ?? '') ?>">
        <?php if (isset($errors['original_language'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['original_language']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="video" class="form-label">Ссылка на видео</label>
        <input type="text" class="form-control <?= isset($errors['video']) ? 'is-invalid' : '' ?>" id="video" name="video" value="<?= htmlspecialchars($old['video'] ?? '') ?>">
        <?php if (isset($errors['video'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['video']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="poster" class="form-label">Постер фильма</label>
        <input type="file" class="form-control <?= isset($errors['poster']) ? 'is-invalid' : '' ?>" id="poster" name="poster">
        <?php if (isset($errors['poster'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['poster']) ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Добавить фильм</button>
</form>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>