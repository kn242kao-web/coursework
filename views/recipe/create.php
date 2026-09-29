<?php
$errors = $errors ?? [];
?>

<h1>Додати нове тренування у розклад</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=trainings/create" class="form">
    <div class="form__group">
        <label for="t_title" class="form__label">Назва заняття <span class="required">*</span></label>
        <input type="text" id="t_title" name="title" class="form__input" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" placeholder="Наприклад: Кросфіт, Силове тренування" required>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="t_trainer" class="form__label">Ім'я тренера <span class="required">*</span></label>
            <input type="text" id="t_trainer" name="trainer_name" class="form__input" value="<?= htmlspecialchars($_POST['trainer_name'] ?? '') ?>" placeholder="Тренер залу" required>
        </div>

        <div class="form__group">
            <label for="t_date" class="form__label">Дата та час <span class="required">*</span></label>
            <input type="datetime-local" id="t_date" name="training_date" class="form__input" value="<?= htmlspecialchars($_POST['training_date'] ?? '') ?>" required>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="t_duration" class="form__label">Тривалість (хв)</label>
            <input type="number" id="t_duration" name="duration_min" class="form__input" min="1" value="<?= htmlspecialchars($_POST['duration_min'] ?? '60') ?>">
        </div>

        <div class="form__group">
            <label for="t_capacity" class="form__label">Кількість місць</label>
            <input type="number" id="t_capacity" name="capacity" class="form__input" min="1" value="<?= htmlspecialchars($_POST['capacity'] ?? '10') ?>">
        </div>
    </div>

    <div class="form__group">
        <label for="t_description" class="form__label">Короткий опис</label>
        <textarea id="t_description" name="description" class="form__textarea" placeholder="Які групи м'язів задіяні або що мати з собою..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Опублікувати заняття</button>
        <a href="index.php?route=trainings/list" class="btn btn--secondary">Назад до списку</a>
    </div>
</form>