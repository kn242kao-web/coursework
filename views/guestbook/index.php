<div class="container py-4">
    <div class="bg-white p-4 rounded-3 shadow-sm border mb-5">
        <form action="" method="POST">

            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary small mb-1">Оберіть тренування:</label>
                    <select name="training_name" class="form-select border-light-subtle" required>
                        <option value="" disabled selected>-- Виберіть із списку --</option>
                        <?php foreach ($trainings as $t): ?>
                            <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary small mb-1">Ваша оцінка:</label>
                    <div class="star-rating-select">
                        <input type="radio" id="st5" name="rating" value="5" checked /><label for="st5" title="5">★</label>
                        <input type="radio" id="st4" name="rating" value="4" /><label for="st4" title="4">★</label>
                        <input type="radio" id="st3" name="rating" value="3" /><label for="st3" title="3">★</label>
                        <input type="radio" id="st2" name="rating" value="2" /><label for="st2" title="2">★</label>
                        <input type="radio" id="st1" name="rating" value="1" /><label for="st1" title="1">★</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <textarea name="comment" class="form-control border-light-subtle" rows="3" 
                          placeholder="Поділіться враженнями про тренерів, тренажери або сервіс..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-2" style="background-color: #2563eb;">
                Додати відгук
            </button>
        </form>
    </div>
    <h3 class="fw-bold text-dark mb-4">
        Всі коментарі атлетів (<?= count($comments) ?>)
    </h3>

    <div class="bg-white rounded-3 shadow-sm border overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-reviews-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">ДАТА</th>
                        <th style="width: 15%;">ІМ'Я АТЛЕТА</th>
                        <th style="width: 20%;">ТРЕНУВАННЯ</th>
                        <th style="width: 15%;">РЕЙТИНГ</th>
                        <th style="width: 35%;">ТЕКСТ ВІДГУКУ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($comments)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Поки немає жодного відгуку</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($comments as $rev): ?>
                            <tr>
                                <td class="text-secondary small"><?= htmlspecialchars($rev['date'] ?? '') ?></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($rev['author'] ?? 'Гість') ?></td>
                                <td>
                                    <?php if (!empty($rev['training'])): ?>
                                        <span class="badge bg-light text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-normal">
                                            🏋️ <?= htmlspecialchars($rev['training']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-warning fw-bold fs-6">
                                        <?php 
                                        $r = (int)($rev['rating'] ?? 5);
                                        for ($i = 1; $i <= 5; $i++): 
                                        ?>
                                            <?= $i <= $r ? '★' : '☆' ?>
                                        <?php endfor; ?>
                                    </span>
                                </td>
                                <td class="text-dark"><?= htmlspecialchars($rev['text'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.custom-reviews-table thead th {
    background-color: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
}

.custom-reviews-table tbody td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
}

.custom-reviews-table tbody tr:last-child td {
    border-bottom: none;
}

.star-rating-select {
    display: inline-flex;
    flex-direction: row-reverse;
    font-size: 26px;
    line-height: 1;
}

.star-rating-select input {
    display: none;
}

.star-rating-select label {
    color: #cbd5e1;
    cursor: pointer;
    padding: 0 3px;
    transition: color 0.15s ease-in-out;
}

.star-rating-select label:hover,
.star-rating-select label:hover ~ label,
.star-rating-select input:checked ~ label {
    color: #f59e0b;
}
</style>