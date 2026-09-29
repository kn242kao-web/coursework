<?php $photos = $photos ?? []; ?>

<div class="container my-4">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Галерея GymMaster</h1>
        <p class="text-muted">Атмосфера та професійне обладнання нашого фітнес-клубу</p>
    </div>

    <?php if (empty($photos)): ?>
        <div class="alert alert-warning text-center">
            Масив з фотографіями порожній або не передався з контролера!
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($photos as $photo): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        <img src="<?= htmlspecialchars($photo['url']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($photo['title']) ?>"
                             style="height: 240px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/800x600?text=GymMaster';">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?= htmlspecialchars($photo['category']) ?></span>
                            <h5 class="card-title fw-bold m-0"><?= htmlspecialchars($photo['title']) ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>