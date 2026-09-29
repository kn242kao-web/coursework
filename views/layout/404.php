<div class="error-page" style="text-align: center; padding: 50px 0;">
    <h1 style="font-size: 5rem; color: #e85d04; margin-bottom: 10px;">404</h1>
    <p class="error-page__message" style="font-size: 1.2rem; margin-bottom: 20px;">
        <?= htmlspecialchars($message ?? 'Сторінку або дію не знайдено в системі GymMaster.') ?>
    </p>
    <a href="index.php?route=index/main" class="btn">На головну сторінку</a>
</div>