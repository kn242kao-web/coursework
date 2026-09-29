<div class="container my-5" style="max-width: 600px;">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 text-dark">Редагувати тренування</h3>
            <a href="index.php?route=trainings/list" class="btn-close" aria-label="Закрити"></a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger rounded-3 mb-4 small">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?route=trainings/edit&id=<?= (int)$training['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label text-secondary fw-medium small mb-1">Назва тренування</label>
                <input type="text" name="title" class="form-control form-control-lg rounded-3 fs-6" 
                       value="<?= htmlspecialchars($training['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary fw-medium small mb-1">Ім'я тренера</label>
                <input type="text" name="trainer_name" class="form-control form-control-lg rounded-3 fs-6" 
                       value="<?= htmlspecialchars($training['trainer_name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary fw-medium small mb-1">Дата та час</label>
                <input type="datetime-local" name="training_date" class="form-control form-control-lg rounded-3 fs-6" 
                       value="<?= htmlspecialchars($training['training_date'] ?? '') ?>" required>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label text-secondary fw-medium small mb-1">Тривалість (хвилин)</label>
                    <input type="number" name="duration_min" class="form-control form-control-lg rounded-3 fs-6" 
                           value="<?= (int)($training['duration_min'] ?? 60) ?>" min="1" required>
                </div>
                <div class="col-6">
                    <label class="form-label text-secondary fw-medium small mb-1">Кількість місць</label>
                    <input type="number" name="capacity" class="form-control form-control-lg rounded-3 fs-6" 
                           value="<?= (int)($training['capacity'] ?? 20) ?>" min="1" required>
                </div>
            </div>

            <div class="d-flex gap-2 pt-2">
                <a href="index.php?route=trainings/list" class="btn btn-light btn-lg w-50 fw-semibold rounded-pill text-secondary border">
                    Скасувати
                </a>
                <button type="submit" class="btn btn-danger btn-lg w-50 fw-semibold rounded-pill shadow-sm">
                    Оновити
                </button>
            </div>

        </form>
    </div>
</div>