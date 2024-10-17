<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Логин</h2>

                    <form action="/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email"
                                   class="form-control <?= !empty($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>"
                                   id="email"
                                   name="email"
                                   value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>">
                            <?php if (!empty($_SESSION['errors']['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['email']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль:</label>
                            <input type="password"
                                   class="form-control <?= !empty($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>"
                                   id="password"
                                   name="password">
                            <?php if (!empty($_SESSION['errors']['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['password']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                            <label class="form-check-label" for="remember_me">Запомнить меня</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Вход</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/register" class="btn btn-link">Регистрация</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['errors'], $_SESSION['form_data']); ?>
