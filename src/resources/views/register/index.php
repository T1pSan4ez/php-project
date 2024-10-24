<div class="container mt-5 mb-5">
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

                    <form action="/register" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label"><span style="color: red">*</span>Имя пользователя:</label>
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
                            <label for="email" class="form-label"><span style="color: red">*</span>Email:</label>
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
                            <label for="password" class="form-label"><span style="color: red">*</span>Пароль:</label>
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

                        <div class="mb-3">
                            <label for="birthdate" class="form-label"><span style="color: red">*</span>Дата рождения:</label>
                            <input type="date" class="form-control <?= !empty($_SESSION['errors']['birthdate']) ? 'is-invalid' : '' ?>" id="birthdate" name="birthdate" value="<?= htmlspecialchars($_SESSION['form_data']['birthdate'] ?? '') ?>">
                            <?php if (!empty($_SESSION['errors']['birthdate'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['birthdate']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span style="color: red">*</span>Пол:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'male') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="male">Мужской</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'female') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="female">Женский</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="another" value="another" <?= (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'another') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="another">Что-то другое...</label>
                            </div>

                            <?php if (!empty($_SESSION['errors']['gender'])): ?>
                                <div class="invalid-feedback" style="display: block;">
                                    <?= htmlspecialchars($_SESSION['errors']['gender']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="countries" class="form-label">Выберите страны:</label>
                            <select name="countries[]" id="countries" class="form-select" multiple>
                                <option value="Украина" <?= (isset($_SESSION['form_data']['countries']) && in_array('Украина', $_SESSION['form_data']['countries'])) ? 'selected' : '' ?>>Украина</option>
                                <option value="Польша" <?= (isset($_SESSION['form_data']['countries']) && in_array('Польша', $_SESSION['form_data']['countries'])) ? 'selected' : '' ?>>Польша</option>
                                <option value="Словакия" <?= (isset($_SESSION['form_data']['countries']) && in_array('Словакия', $_SESSION['form_data']['countries'])) ? 'selected' : '' ?>>Словакия</option>
                                <option value="Румыния" <?= (isset($_SESSION['form_data']['countries']) && in_array('Румыния', $_SESSION['form_data']['countries'])) ? 'selected' : '' ?>>Румыния</option>
                                <option value="Молдова" <?= (isset($_SESSION['form_data']['countries']) && in_array('Молдова', $_SESSION['form_data']['countries'])) ? 'selected' : '' ?>>Молдова</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Изображение профиля:</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Предпочтительный рейтинг фильмов (1.0 - 10.0):</label>
                            <input type="number" step="0.1" min="1" max="10" class="form-control <?= !empty($_SESSION['errors']['preferred_rating']) ? 'is-invalid' : '' ?>" id="rating" name="rating" value="<?= htmlspecialchars($_SESSION['form_data']['preferred_rating'] ?? '') ?>">
                            <?php if (!empty($_SESSION['errors']['preferred_rating'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['preferred_rating']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Предпочтения по уведомлениям:</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="new_releases" name="notifications[]" value="new_releases" <?= (isset($_SESSION['form_data']['notifications']) && in_array('new_releases', $_SESSION['form_data']['notifications'])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="new_releases">Получать уведомления о новых фильмах</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="top_rated" name="notifications[]" value="top_rated" <?= (isset($_SESSION['form_data']['notifications']) && in_array('top_rated', $_SESSION['form_data']['notifications'])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="top_rated">Получать уведомления о самых рейтинговых фильмах</label>
                            </div>
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
