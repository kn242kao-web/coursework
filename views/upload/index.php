<?php
$images = $images ?? [];
$message = $message ?? '';
$error = $error ?? '';
$title = $title ?? 'Галерея залу GymMaster';
?>

<div class="hero-section">
    <h1><?= htmlspecialchars($title) ?></h1>
    <p>Діліться своїми результатами! Завантажуйте фото з тренувань (JPEG, PNG, GIF, WebP, до 5 МБ).</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card" style="margin-bottom: 40px;">
    <form method="POST" action="index.php?controller=upload&action=upload" enctype="multipart/form-data" class="form">
        <div class="form__row" style="align-items: flex-end;">
            <div class="form__group" style="flex: 2;">
                <label for="upload_image" class="form__label">Оберіть фотографію <span class="required">*</span></label>
                <input type="file" id="upload_image" name="image" class="form__input" accept="image/jpeg,image/png,image/gif,image/webp" required>
            </div>
            <div class="form__actions" style="margin-bottom: 15px;">
                <button type="submit" class="btn btn--accent">Опублікувати у стрічці</button>
            </div>
        </div>
        <small class="text-muted">Максимальний розмір файлу: 5 МБ. Формати: JPG, PNG, GIF, WebP.</small>
    </form>
</div>

<hr class="separator">

<h2>Стрічка досягнень (<?= count($images) ?> фото)</h2>

<?php if (empty($images)): ?>
    <div class="empty-state">
        <p class="text-muted">Галерея поки порожня. Станьте першим, хто завантажить своє фото!</p>
    </div>
<?php else: ?>
    <div class="gallery">
        <?php foreach ($images as $img): ?>
            <div class="gallery__item card">
                <div class="gallery__img-container">
                    <img src="<?= htmlspecialchars($img['url']) ?>" alt="Тренування в GymMaster" class="gallery__img" loading="lazy">
                </div>
                <div class="gallery__info">
                    <div class="gallery__meta">
                        <span class="gallery__date">📅 <?= htmlspecialchars($img['date']) ?></span>
                        <span class="gallery__size">📏 <?= round($img['size'] / 1024) ?> КБ</span>
                    </div>
                    <div class="gallery__filename">
                        <code><?= htmlspecialchars($img['name']) ?></code>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.gallery__item {
    overflow: hidden;
    padding: 10px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.gallery__img-container {
    height: 200px;
    overflow: hidden;
    border-radius: 4px;
    margin-bottom: 10px;
}
.gallery__img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
    transition: transform 0.3s ease;
}
.gallery__img:hover {
    transform: scale(1.05);
}
.gallery__meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 5px;
}
.gallery__filename {
    font-size: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #999;
}
.btn--accent {
    background-color: #e85d04; 
    color: white;
}
</style>