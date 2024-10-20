<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <img src="/uploads/profile_image.jpg" class="card-img-top" alt="Profile Image" width="150">
                    <h2 class="text-center mb-4">Профиль пользователя</h2>

                    <div class="profile-info mb-4">
                        <p><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Имя не задано') ?></p>
                        <p><strong>Почта:</strong> <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Почта не задана') ?></p>

                        <?php if (!empty($_SESSION['user']['profile_image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($_SESSION['user']['profile_image']) ?>" class="card-img-top" alt="Profile Image" width="150">
                        <?php else: ?>
                            <p>Изображение не загружено</p>
                        <?php endif; ?>
                    </div>

                    <form action="/profile/update" method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="name">Имя:</label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                        </div>

                        <div>
                            <label for="password">Новый пароль:</label>
                            <input type="password" id="password" name="password">
                        </div>

                        <div>
                            <label for="profile_image">Изображение профиля:</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*">
                        </div>

                        <button type="submit">Сохранить изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['errors'], $_SESSION['form_data']); ?>
