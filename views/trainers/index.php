<?php
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-white fw-bold m-0">Наші тренери</h1>
    </div>
    <div class="trainers-grid">
        <?php foreach ($trainers as $trainer): ?>
            <div class="trainer-card">
                <a href="index.php?route=trainers/view&id=<?= $trainer['id'] ?>" class="trainer-card__link">
                    <div class="trainer-card__image-wrapper">
                        <img src="<?= htmlspecialchars($trainer['photo']) ?>" 
                             alt="<?= htmlspecialchars($trainer['name']) ?>" 
                             class="trainer-card__image">
                        
                        <div class="trainer-card__action-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="trainer-card__content">
                        <div class="trainer-card__badges mb-2">
                            <span class="trainer-badge trainer-badge--pink">
                                <?= htmlspecialchars($trainer['role'] ?? 'Персональний тренер') ?>
                            </span>
                            <?php if (!empty($trainer['secondary_role'])): ?>
                                <span class="trainer-badge trainer-badge--teal">
                                    <?= htmlspecialchars($trainer['secondary_role']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <h3 class="trainer-card__title">
                            <?= htmlspecialchars($trainer['name']) ?>
                        </h3>

                        <p class="trainer-card__spec">
                            <?= htmlspecialchars($trainer['specialization'] ?? '') ?>
                        </p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.trainers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
    width: 100%;
}

.trainer-card {
    background-color: #1f2123;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.trainer-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
}

.trainer-card__link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.trainer-card__image-wrapper {
    position: relative;
    width: 100%;
    height: 320px;
    overflow: hidden;
    background-color: #121314;
}

.trainer-card__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    transition: transform 0.4s ease;
}

.trainer-card:hover .trainer-card__image {
    transform: scale(1.04);
}

.trainer-card__action-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 36px;
    height: 36px;
    background-color: #ffffff;
    color: #121314;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.trainer-card:hover .trainer-card__action-btn {
    background-color: #f1f5f9;
    transform: scale(1.1);
}

.trainer-card__content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.trainer-card__badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.trainer-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 12px;
    color: #ffffff;
    line-height: 1.2;
}

.trainer-badge--pink {
    background-color: #e11d48;
}

.trainer-badge--teal {
    background-color: #0d9488;
}

.trainer-card__title {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    margin: 8px 0;
}

.trainer-card__spec {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
    line-height: 1.4;
}
</style>