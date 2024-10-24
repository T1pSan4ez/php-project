<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Текущая дата</h5>
                    <p class="card-text">
                       <?= date('d-m-Y') ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Всего лайков</h5>
                    <p class="card-text"><?= htmlspecialchars($totalLikes) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Всего комментариев</h5>
                    <p class="card-text"><?= htmlspecialchars($totalComments) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Всего фильмов</h5>
                    <p class="card-text"><?= htmlspecialchars($totalMovies) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Всего жанров</h5>
                    <p class="card-text"><?= htmlspecialchars($totalGenres) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Всего пользователей</h5>
                    <p class="card-text"><?= htmlspecialchars($totalUsers) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
