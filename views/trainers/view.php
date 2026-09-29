<div class="container py-5">
    <a href="index.php?route=trainers/index" class="text-decoration-none text-light mb-4 d-inline-flex align-items-center gap-2 opacity-75 hover-opacity-100">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Назад до всіх тренерів
    </a>
    <div class="trainer-profile-card">
        
        <div class="trainer-profile__header">
            <div class="trainer-profile__photo-box">
                <img src="<?= htmlspecialchars($trainer['photo']) ?>" 
                     alt="<?= htmlspecialchars($trainer['name']) ?>" 
                     class="trainer-profile__photo">
            </div>
            <div class="trainer-profile__header-info">
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
                <h1 class="trainer-profile__name">
                    <?= htmlspecialchars($trainer['name']) ?>
                </h1>
                <?php if (!empty($trainer['subtitle'])): ?>
                    <p class="trainer-profile__subtitle">
                        <?= htmlspecialchars($trainer['subtitle']) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($trainer['bio'])): ?>
            <div class="trainer-profile__bio">
                <?= nl2br(htmlspecialchars($trainer['bio'])) ?>
            </div>
        <?php endif; ?>
        <div class="row g-4 mt-2">
            <?php if (!empty($trainer['specialization_list'])): ?>
                <div class="col-md-4">
                    <div class="trainer-profile__section-box">
                        <h4 class="trainer-profile__section-title">Спеціалізація:</h4>
                        <ul class="trainer-profile__list">
                            <?php foreach ($trainer['specialization_list'] as $item): ?>
                                <li>• <?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($trainer['workout_types'])): ?>
                <div class="col-md-4">
                    <div class="trainer-profile__section-box">
                        <h4 class="trainer-profile__section-title">Види тренувань:</h4>
                        <ul class="trainer-profile__list">
                            <?php foreach ($trainer['workout_types'] as $item): ?>
                                <li>• <?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($trainer['education'])): ?>
                <div class="col-md-4">
                    <div class="trainer-profile__section-box">
                        <h4 class="trainer-profile__section-title">Освіта та сертифікати:</h4>
                        <ul class="trainer-profile__list">
                            <?php foreach ($trainer['education'] as $item): ?>
                                <li>• <?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.trainer-profile-card {
    background-color: #1f2123;
    border-radius: 20px;
    padding: 32px;
    color: #ffffff;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}
.trainer-profile__header {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    margin-bottom: 24px;
}

.trainer-profile__photo-box {
    width: 180px;
    height: 180px;
    min-width: 180px;
    border-radius: 16px;
    overflow: hidden;
    background-color: #121314;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.trainer-profile__photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

.trainer-profile__header-info {
    flex-grow: 1;
}

.trainer-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 10px;
    color: #ffffff;
    display: inline-block;
}
.trainer-badge--pink { background-color: #e11d48; }
.trainer-badge--teal { background-color: #0d9488; }

.trainer-profile__name {
    font-size: 32px;
    font-weight: 800;
    margin: 8px 0 12px 0;
    color: #ffffff;
    line-height: 1.2;
}

.trainer-profile__subtitle {
    font-size: 14px;
    color: #cbd5e1;
    line-height: 1.5;
    margin: 0;
}

.trainer-profile__bio {
    font-size: 14px;
    color: #cbd5e1;
    line-height: 1.6;
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #2d3135;
}

.trainer-profile__section-box {
    background-color: #151718;
    border-radius: 14px;
    padding: 20px;
    height: 100%;
}

.trainer-profile__section-title {
    font-size: 15px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 12px;
}

.trainer-profile__list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.trainer-profile__list li {
    font-size: 13px;
    color: #94a3b8;
    line-height: 1.4;
}

@media (max-width: 576px) {
    .trainer-profile__header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .trainer-profile__photo-box {
        width: 160px;
        height: 160px;
        min-width: 160px;
    }
}
</style>