<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><?= htmlspecialchars($film['title']) ?></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="/uploads/films-one.jpg" class="img-fluid" alt="<?= htmlspecialchars($film['title']) ?>">

                            <div class="mb-3">
                                <strong>Дата выхода:</strong>
                                <p><?= htmlspecialchars($film['release_date']) ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>ID фильма:</strong> <?= htmlspecialchars($film['id']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Популярность IMDB:</strong> <?= htmlspecialchars($film['popularity']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Рейтинг IMDB:</strong> <?= number_format((float)$film['vote_average'], 2); ?>
                            </div>
                            <div class="mb-2">
                                <strong>Жанр:</strong>
                                <?php foreach ($genres as $genre): ?>
                                     <?= htmlspecialchars($genre['name']) ?>;
                                <?php endforeach; ?>
                            </div>
                            <div class="mb-2">

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Описание:</strong>
                        <p class="card-text"><?= htmlspecialchars($film['overview']) ?></p>
                    </div>
                </div>

                <div class="card-footer">
                    <strong>Комментарии:</strong>
                    <form action="/add-comment" method="POST" >
                        <div class="form-group">
                            <label for="comment_text">Добавить комментарий:</label>
                            <textarea name="comment_text" class="form-control" id="comment_text" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="movie_id" value="<?= htmlspecialchars($film['id']) ?>">
                        <button type="submit" class="btn btn-primary mt-3">Отправить</button>
                    </form>

                    <?php if (!empty($comments)): ?>
                        <div class="comments-list mt-3">
                            <?php foreach ($comments as $comment): ?>
                                <div class="row mb-3 p-3 border rounded shadow-sm">
                                    <div class="col-auto">
                                        <?php
                                        $profileImage = isset($comment['user_avatar']) && !empty($comment['user_avatar'])
                                            ? '/uploads/' . htmlspecialchars($comment['user_avatar'])
                                            : 'https://via.placeholder.com/64';
                                        ?>
                                        <img src="<?= $profileImage ?>" class="rounded-circle" alt="User avatar" width="64" height="64">
                                    </div>

                                    <div class="col">
                                        <h5 class="mt-0 mb-0"><?= htmlspecialchars($comment['username']) ?></h5>
                                        <p class="mb-0"><?= htmlspecialchars($comment['comment_text']) ?></p>
                                        <small class="text-muted"><?= htmlspecialchars($comment['created_at']) ?></small>
                                    </div>

                                    <div class="col-auto">
                                        <?php if (
                                            isset($_SESSION['user']) &&
                                            ($_SESSION['user']['id'] === $comment['user_id'] || ($_SESSION['user']['admin_role'] ?? 0) == 1)
                                        ): ?>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= htmlspecialchars($comment['id']) ?>)">
                                                Удалить
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Навигация по комментариям">
                                <ul class="pagination justify-content-center mt-4">
                                    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Предыдущая">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                        <li class="page-item <?= ($page == $currentPage) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Следующая">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    <?php else: ?>
                        <p class="text-muted">Комментариев пока нет.</p>
                    <?php endif; ?>
                </div>

                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="errorModalLabel">Ошибка</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= htmlspecialchars($error ?? ''); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ОК</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        <?php if (!empty($error)): ?>
                        var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                        modal.show();
                        <?php endif; ?>
                    });
                </script>

                <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteCommentModalLabel">Подтверждение удаления</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                            </div>
                            <div class="modal-body">
                                Вы уверены, что хотите удалить этот комментарий?
                            </div>
                            <div class="modal-footer">
                                <form id="deleteCommentForm" action="/delete-comment" method="POST">
                                    <input type="hidden" name="comment_id" id="commentId">
                                    <input type="hidden" name="movie_id" value="<?= htmlspecialchars($movieId) ?>">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function confirmDelete(commentId) {
                        var deleteModal = new bootstrap.Modal(document.getElementById('deleteCommentModal'), {
                            keyboard: false
                        });
                        document.getElementById('commentId').value = commentId;
                        deleteModal.show();
                    }
                </script>
            </div>
        </div>
    </div>
</div>
