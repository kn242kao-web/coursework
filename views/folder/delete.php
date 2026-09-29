<?php
$message = $message ?? '';
$error = $error ?? '';
?>

<h1>Видалення каталогу</h1>
<p>Введіть логін — папку <code>data/users/{логін}/</code> буде видалено з усім вмістом.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=folder/delete" class="form">
    <div class="form__row" style="display: flex; gap: 15px; margin-bottom: 15px;">
        <div class="form__group" style="flex: 1;">
            <label for="del_login" class="form__label">Логін <span class="required">*</span></label>
            <input type="text" id="del_login" name="login" class="form__input" required
                   value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                   placeholder="Ім'я папки для видалення">
        </div>
        <div class="form__group" style="flex: 1;">
            <label for="del_password" class="form__label">Пароль</label>
            <input type="password" id="del_password" name="password" class="form__input"
                   placeholder="Підтвердження">
        </div>
    </div>

    <div class="form__actions" style="display: flex; gap: 10px;">
        <button type="submit" class="btn btn--danger">Видалити каталог</button>
        <a href="index.php?route=folder/create" class="btn btn--secondary">Назад до створення</a>
    </div>
</form>