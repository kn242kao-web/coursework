<div class="page-home">
    <h1>Тренажерний зал «GymMaster»</h1>
    <p class="page-home__subtitle">Варіант 11 &mdash; Лабораторна робота №5</p>
    <p class="text-muted">Професійна система управління тренуваннями. Файлова гостьова книга, галерея успіхів атлетів, CRUD тренувань через PDO, авторизація користувачів.</p>

    <h2>Файли (Робота з ФС)</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Гостьова книга</h3>
            <p class="card__text">Залишайте відгуки про роботу залу та тренерів. Коментарі зберігаються у текстовому файлі.</p>
            <a href="index.php?route=guestbook/index" class="btn btn--small">Відгуки</a>
        </div>

        <div class="card">
            <h3 class="card__title">Галерея залу</h3>
            <p class="card__text">Завантажуйте фото ваших результатів та тренувань. Файлова галерея спортивних досягнень.</p>
            <a href="index.php?route=gallery/index" class="btn btn--small">Галерея</a>
        </div>

        <div class="card">
            <h3 class="card__title">Каталоги атлетів</h3>
            <p class="card__text">Персональні папки клієнтів зі структурою для відео-уроків, мотиваційної музики та фото.</p>
            <a href="index.php?route=folder/create" class="btn btn--small">Каталоги</a>
        </div>
    </div>

    <h2>База даних (PDO)</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Тренування (CRUD)</h3>
            <p class="card__text">Керування списком вправ, підходів та графіком занять. Використовується PDO + SQLite/MySQL.</p>
            <a href="index.php?route=trainings/list" class="btn btn--small">До занять</a>
        </div>

        <div class="card">
            <h3 class="card__title">Особистий кабінет</h3>
            <p class="card__text">Реєстрація нових атлетів, авторизація через сесії, безпечне хешування паролів.</p>
            <a href="index.php?route=auth/login" class="btn btn--small">Увійти</a>
        </div>

        <div class="card">
            <h3 class="card__title">Персоналізація</h3>
            <p class="card__text">Налаштування теми інтерфейсу (сесії) та збереження імені атлета (куки) з ЛР4.</p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштувати</a>
        </div>
    </div>
</div>