<?php
?>

<div class="container mt-4">
    <div class="gallery-page">
        <h1 class="fw-bold text-dark">Галерея залу</h1>
        <p class="text-secondary">Діліться своїми результатами! Завантажуйте фото з тренувань (JPEG, PNG, GIF, WebP, до 5 МБ).</p>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card p-4 shadow-sm mb-5 bg-white border-0" style="border-radius: 12px;">
            <h5 class="fw-bold mb-3">Оберіть фотографію *</h5>
            <form action="index.php?route=gallery" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" required>
                </div>
                <button type="submit" class="btn btn-orange text-white fw-bold" style="background-color: #e65c00;">
                    Опублікувати у стрічці
                </button>
            </form>
            <small class="text-muted mt-2 d-block">Максимальний розмір файлу: 5 МБ. Формати: JPG, PNG, GIF, WebP.</small>
        </div>

        <h3 class="fw-bold text-dark mb-4">Стрічка досягнень (<?= count($photos) ?> photo)</h3>
        
        <?php if (!empty($photos)): ?>
            <div class="row">
                <?php foreach ($photos as $photo): ?>
                    <?php 
                        $fileName = basename($photo); 
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 h-100" style="overflow: hidden; border-radius: 8px; position: relative;">
                            <img src="<?= htmlspecialchars($photo) ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Фото тренування">
                            
                            <div class="card-body p-2 bg-light text-center">
                                <a href="index.php?route=gallery/delete&file=<?= urlencode($fileName) ?>" 
                                   class="btn btn-sm btn-danger w-100 fw-bold" 
                                   onclick="return confirm('Ви впевнені, що хочете видалити це фото з галереї?');">
                                    Видалити фото
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted italic">Галерея поки порожня. Станьте першим, хто завантажить своє фото!</p>
        <?php endif; ?>
    </div>
</div>