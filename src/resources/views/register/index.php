<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Регистрация</h2>
                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Успех!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?= htmlspecialchars($_SESSION['success']) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="modalOkButton">ОК</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            window.onload = function() {
                                var modal = new bootstrap.Modal(document.getElementById('successModal'));
                                modal.show();
                            };

                            document.getElementById('modalOkButton').addEventListener('click', function() {
                                window.location.href = '/login';
                            });
                        </script>

                        <?php unset($_SESSION['success']);?>
                    <?php endif; ?>

                    <form action="/register" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Имя пользователя:</label>
                            <input type="text"
                                   class="form-control <?= !empty($_SESSION['errors']['username']) ? 'is-invalid' : '' ?>"
                                   id="username"
                                   name="username"
                                   value="<?= htmlspecialchars($_SESSION['form_data']['username'] ?? '') ?>">
                            <?php if (!empty($_SESSION['errors']['username'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['username']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

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

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Зарегистрироваться</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/login" class="btn btn-link">Уже есть аккаунт? Войти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['errors'], $_SESSION['form_data']); ?>
