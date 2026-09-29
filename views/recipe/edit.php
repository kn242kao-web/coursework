<?php
$item = $item ?? [];
$errors = $errors ?? [];
?>

<h1>Редагувати тренування #<?= (int)($item['id'] ?? 0) ?></h1>

<form method="POST" action="index.php?route=trainings/edit&id=<?= (int)($item['id'] ?? 0) ?>" class="form">
    <div class="form__group">
        <label for="t_title" class="form__label">Назва заняття <span class="required">*</span></label>
        <input type="text" id="t_title" name="title" class="form__input" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="t_trainer" class="form__label">Ім'я тренера <span class="required">*</span></label>
            <input type="text" id="t_trainer" name="trainer_name" class="form__input" value="<?= htmlspecialchars($item['trainer_name'] ?? '') ?>" required>
        </div>

        <div class="form__group">
            <label for="t_date" class="form__label">Дата та час проведення <span class="required">*</span></label>
            <input type="datetime-local" id="t_date" name="training_date" class="form__input" value="<?= htmlspecialchars(!empty($item['training_date']) ? date('Y-m-d\TH:i', strtotime($item['training_date'])) : '') ?>" required>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="t_duration" class="form__label">Тривалість (хв)</label>
            <input type="number" id="t_duration" name="duration_min" class="form__input" min="1" value="<?= htmlspecialchars($item['duration_min'] ?? '60') ?>">
        </div>

        <div class="form__group">
            <label for="t_capacity" class="form__label">Макс. кількість місць</label>
            <input type="number" id="t_capacity" name="capacity" class="form__input" min="1" value="<?= htmlspecialchars($item['capacity'] ?? '10') ?>">
        </div>
    </div>

    <div class="form__group">
        <label for="t_description" class="form__label">Опис тренування / Програма</label>
        <textarea id="t_description" name="description" class="form__textarea" rows="4"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти зміни</button>
        <a href="index.php?route=trainings/list" class="btn btn--secondary">Скасувати</a>
    </div>
</form>