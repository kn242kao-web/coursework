<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація - GymMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6fb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333333;
        }

        header a, 
        nav a, 
        .navbar a {
            text-decoration: none !important;
        }

        .register-container {
            max-width: 620px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .form-title {
            color: #0d1b3e;
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 24px;
        }

        .form-label-custom {
            font-weight: 600;
            font-size: 14px;
            color: #2b3445;
            margin-bottom: 6px;
            display: block;
        }
        .text-asterisk {
            color: #e63946;
            margin-left: 2px;
        }

        .form-control-custom {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            width: 100%;
            background-color: #ffffff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control-custom:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }
        .form-control-custom::placeholder {
            color: #a0aec0;
        }

        .form-check-custom {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            cursor: pointer;
            font-size: 14px;
            color: #2b3445;
        }
        .form-check-custom input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .btn-register {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        .btn-register:hover {
            background-color: #0b5ed7;
            color: #ffffff;
        }

        .btn-login-link {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none !important;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-login-link:hover {
            background-color: #5c636a;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2 class="form-title">Реєстрація</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger rounded-3 py-2 px-3 mb-3 fs-6">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?route=register_process" method="POST">
            
            <div class="mb-3">
                <label class="form-label-custom">Логін <span class="text-asterisk">*</span></label>
                <input type="text" name="login" class="form-control-custom" 
                       placeholder="3-30 символів (латинські, цифри, _)" 
                       value="<?= htmlspecialchars($old['login'] ?? '') ?>" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Пароль <span class="text-asterisk">*</span></label>
                    <input type="password" name="password" class="form-control-custom" 
                           placeholder="Мінімум 6 символів" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Підтвердження <span class="text-asterisk">*</span></label>
                    <input type="password" name="password_confirm" class="form-control-custom" 
                           placeholder="Повторіть пароль" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">E-mail <span class="text-asterisk">*</span></label>
                <input type="email" name="email" class="form-control-custom" 
                       placeholder="user@example.com" 
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Ім'я <span class="text-asterisk">*</span></label>
                    <input type="text" name="first_name" class="form-control-custom" 
                           value="<?= htmlspecialchars($old['first_name'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Прізвище <span class="text-asterisk">*</span></label>
                    <input type="text" name="last_name" class="form-control-custom" 
                           value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Телефон</label>
                    <input type="text" name="phone" class="form-control-custom" 
                           placeholder="+380..." 
                           value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Місто</label>
                    <input type="text" name="city" class="form-control-custom" 
                           value="<?= htmlspecialchars($old['city'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Стать</label>
                <div class="d-flex align-items-center pt-1">
                    <label class="form-check-custom">
                        <input type="radio" name="gender" value="male" <?= ($old['gender'] ?? '') === 'male' ? 'checked' : '' ?>> Чоловіча
                    </label>
                    <label class="form-check-custom">
                        <input type="radio" name="gender" value="female" <?= ($old['gender'] ?? '') === 'female' ? 'checked' : '' ?>> Жіноча
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Про себе</label>
                <textarea name="about" class="form-control-custom" rows="3" 
                          placeholder="Коротко про себе..."><?= htmlspecialchars($old['about'] ?? '') ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-register">Зареєструватися</button>
                <a href="index.php?route=login" class="btn-login-link">Вже є акаунт? Увійти</a>
            </div>

        </form>
    </div>

</body>
</html>