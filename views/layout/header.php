<?php
$bgColor = $_SESSION['bg_color'] ?? '#f8f9fa';
$welcomeMessage = $_COOKIE['welcome'] ?? '';
$isLoggedIn = isset($_SESSION['user_id']);
$userLogin = $_SESSION['user_login'] ?? '';
$currentRoute = $_GET['route'] ?? 'index/main';

$navItems = [
    ['label' => 'Головна',       'route' => 'index/main'],
    ['label' => 'Тренування',    'route' => 'trainings/list'],
    ['label' => 'Тренери',       'route' => 'trainers/index'],
    ['label' => 'Відгуки',       'route' => 'guestbook/index'],
    ['label' => 'Каталоги',      'route' => 'folder/create'],
    ['label' => 'Налаштування',  'route' => 'settings/color'],
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'GymMaster') ?> — Твій шлях до сили</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { 
            background-color: <?= htmlspecialchars($bgColor) ?>; 
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">Перейти до вмісту</a>

    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php?route=index/main" class="header__logo">
                    GYM<span>MASTER</span>
                </a>

                <div class="header__right">
                    <?php if ($welcomeMessage !== ''): ?>
                        <span class="header__greeting"><?= htmlspecialchars($welcomeMessage) ?></span>
                    <?php endif; ?>

                    <div class="header__auth">
                        <?php if ($isLoggedIn): ?>
                            <a href="index.php?route=auth/profile" class="header__auth-link">
                                <strong><?= htmlspecialchars($userLogin) ?></strong>
                            </a>
                            <a href="index.php?route=auth/logout" class="header__auth-link header__auth-link--logout">Вийти</a>
                        <?php else: ?>
                            <a href="index.php?route=auth/login" class="header__auth-link">Увійти</a>
                            <a href="index.php?route=auth/register" class="header__auth-link">Реєстрація</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <nav class="nav">
                <ul class="nav__list">
                    <?php foreach ($navItems as $item): 
                        $isActive = ($currentRoute === $item['route']);
                    ?>
                        <li class="nav__item">
                            <a href="index.php?route=<?= $item['route'] ?>"
                               class="nav__link <?= $isActive ? 'nav__link--active' : '' ?>">
                                <?= htmlspecialchars($item['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main" id="main-content">
        <div class="container">
            
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert alert--success">
                    <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="alert alert--error">
                    <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>