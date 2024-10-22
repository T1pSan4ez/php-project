
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-auto">
            <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filtersForm" aria-expanded="false" aria-controls="filtersForm">
                Показать фильтры
            </button>
        </div>

        <div class="col">
            <form class="d-flex" role="search" action="/films" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Поиск фильмов..." aria-label="Search" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form>
        </div>
    </div>
</div>

<div  class="collapse container mb-3" id="filtersForm" >
    <div class="card card-body">
        <form action="/films" method="GET">
            <div class="mb-3 row">
                <div class="mb-3">
                    <label class="form-label">Жанры</label>
                    <div class="d-flex flex-wrap">
                        <?php foreach ($genres as $genre): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="genre_<?= $genre['id'] ?>" name="genre[]" value="<?= htmlspecialchars($genre['id']) ?>" <?= (isset($_GET['genre']) && in_array($genre['id'], (array)$_GET['genre'])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="genre_<?= $genre['id'] ?>">
                                    <?= htmlspecialchars($genre['name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="sort_by" class="form-label">Сортировать по рейтингу</label>
                <select class="form-select" id="sort_by" name="sort_by">
                    <option value="">Выберите сортировку</option>
                    <option value="asc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'asc') ? 'selected' : '' ?>>По возрастанию</option>
                    <option value="desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'desc') ? 'selected' : '' ?>>По убыванию</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Применить фильтры</button>
        </form>
    </div>
</div>

<?php if (!empty($films)): ?>
    <div class="container">
        <div class="row">
            <?php foreach ($films as $index => $film): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100" style="width: 100%;">
                    <a href="/films/<?= htmlspecialchars($film['id'] ?? '') ?>">
                        <?php
                        $posterPath = !empty($film['poster_path']) ? '/uploads/' . htmlspecialchars($film['poster_path']) : '';

                        if (!empty($posterPath) && file_exists($_SERVER['DOCUMENT_ROOT'] . $posterPath)): ?>
                            <img src="<?= $posterPath ?>" class="card-img-top" alt="<?= htmlspecialchars($film['title'] ?? 'No title') ?>">
                        <?php else: ?>
                            <img src="/uploads/films-one.jpg" class="card-img-top" alt="<?= htmlspecialchars($film['title'] ?? 'No title') ?>">
                        <?php endif; ?>
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($film['original_title']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($film['release_date']); ?></p>
                        <p class="card-text">Rating: <?= number_format((float)$film['vote_average'], 2); ?></p>
                    </div>
                </div>
            </div>
            <?php if (($index + 1) % 4 == 0): ?>
        </div><div class="row">
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center mt-4" role="alert">
        <strong>Упс!</strong> Фильмы не найдены по вашему запросу. Попробуйте изменить фильтры или поиск.
    </div>
<?php endif; ?>

<?php
$currentQueryParams = $_GET;
unset($currentQueryParams['page']);

$queryString = !empty($currentQueryParams) ? http_build_query($currentQueryParams) : '';

$maxVisiblePages = 7;

$startPage = max(1, $page - floor($maxVisiblePages / 2));
$endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

if ($endPage - $startPage < $maxVisiblePages - 1) {
    $startPage = max(1, $endPage - $maxVisiblePages + 1);
}
?>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1<?= $queryString ? '&' . $queryString : '' ?>" aria-label="First">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?><?= $queryString ? '&' . $queryString : '' ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?><?= $queryString ? '&' . $queryString : '' ?>" aria-label="Last">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>



