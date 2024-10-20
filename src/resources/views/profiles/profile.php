<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Профиль пользователя</h2>

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success text-center">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-center">
                            <?php
                            $profileImage = !empty($_SESSION['user']['profile_image']) ? htmlspecialchars($_SESSION['user']['profile_image']) : 'default-profile.jpg';
                            ?>
                            <img src="/uploads/<?= $profileImage ?>" class="img-fluid rounded-circle" alt="Profile Image" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <p><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Имя не задано') ?></p>
                            <p><strong>Почта:</strong> <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Почта не задана') ?></p>
                        </div>
                    </div>

                    <form action="/profile/update" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name">Имя:</label>
                            <input type="text" class="form-control <?= !empty($_SESSION['errors']['username']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                            <?php if (!empty($_SESSION['errors']['username'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['username']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password">Новый пароль:</label>
                            <input type="password" class="form-control <?= !empty($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
                            <?php if (!empty($_SESSION['errors']['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['password']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="profile_image">Изображение профиля:</label>
                            <input type="file" class="form-control <?= !empty($_SESSION['errors']['profile_image']) ? 'is-invalid' : '' ?>" id="profile_image" name="profile_image" accept="image/*">
                            <?php if (!empty($_SESSION['errors']['profile_image'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['profile_image']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['errors'], $_SESSION['message']); ?>
