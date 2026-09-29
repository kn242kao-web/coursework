<?php
?>

<div class="settings-page">
    <h1 class="settings-page__title">Колір фону (Сесії)</h1>
    
    <p class="settings-page__description">
        Оберіть колір фону сторінки. Значення зберігається в <code>$_SESSION</code> та діє на всіх сторінках до закриття браузера.
    </p>

    <?php if (!empty($message)): ?>
        <div class="alert alert--success" style="margin-bottom: 20px; padding: 10px; background: #dcfce7; color: #166534; border-radius: 6px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert--error" style="margin-bottom: 20px; padding: 10px; background: #fee2e2; color: #991b1b; border-radius: 6px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?route=settings/color" method="POST" class="color-form">
        <div class="color-grid">
            <?php foreach ($colors as $hex => $name): 
                $isCurrent = ($hex === $currentColor);
            ?>
                <label class="color-card <?= $isCurrent ? 'color-card--active' : '' ?>">
                    <input type="radio" name="bg_color" value="<?= $hex ?>" <?= $isCurrent ? 'checked' : '' ?> class="color-card__radio">
                    
                    <div class="color-card__circle" style="background-color: <?= $hex ?>; border: 1px solid #d1d5db;"></div>
                    
                    <span class="color-card__name"><?= htmlspecialchars($name) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="form-actions" style="margin-top: 30px;">
            <button type="submit" class="btn btn--primary" style="padding: 12px 24px; background-color: #2563eb; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.2s;">
                Зберегти колір
            </button>
        </div>
    </form>

    <p class="settings-page__footer" style="margin-top: 25px; color: #6b7280; font-size: 0.95rem;">
        Модуль успадковано з ЛР4. Також доступне <a href="index.php?route=settings/greeting" style="color: #2563eb; text-decoration: none; border-bottom: 1px dashed #2563eb;">привітання через Cookie</a>.
    </p>
</div>

<style>
    .color-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .color-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        text-align: center;
    }

    .color-card:hover {
        border-color: #93c5fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .color-card--active {
        border-color: #2563eb;
        background-color: #eff6ff;
        box-shadow: 0 0 0 1px #2563eb;
    }

    .color-card__radio {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .color-card__circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-bottom: 12px;
        transition: transform 0.2s;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
    }

    .color-card:hover .color-card__circle {
        transform: scale(1.05);
    }

    .color-card__name {
        font-size: 0.875rem;
        color: #4b5563;
        font-weight: 500;
    }
    
    .color-card--active .color-card__name {
        color: #1e40af;
        font-weight: 600;
    }
</style>