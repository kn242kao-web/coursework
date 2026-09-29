<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_bookings'])) {
    $_SESSION['user_bookings'] = []; 
}

if (isset($_GET['action']) && $_GET['action'] === 'book' && isset($_GET['id'])) {
    $bookId = (int)$_GET['id'];
    if (!in_array($bookId, $_SESSION['user_bookings'])) {
        $_SESSION['user_bookings'][] = $bookId;
        $_SESSION['flash_success'] = "Ви успішно записалися на тренування!";
    }
    header("Location: index.php?route=trainings");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'unbook' && isset($_GET['id'])) {
    $unbookId = (int)$_GET['id'];
    $key = array_search($unbookId, $_SESSION['user_bookings']);
    if ($key !== false) {
        unset($_SESSION['user_bookings'][$key]);
        $_SESSION['user_bookings'] = array_values($_SESSION['user_bookings']);
        $_SESSION['flash_success'] = "Запис успішно скасовано!";
    }
    header("Location: index.php?route=trainings");
    exit();
}

$isAdmin = $isAdmin 
    || !empty($_SESSION['is_admin']) 
    || !empty($_SESSION['user']['is_admin']) 
    || (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');

$trainings = $trainings ?? [
    ['id' => 1, 'title' => 'Pilates', 'training_date' => '2026-09-17 18:00:00', 'duration_min' => 60, 'trainer_name' => 'Владислава Александрова', 'capacity' => 10, 'booked' => 3, 'rating' => '4.9'],
    ['id' => 2, 'title' => 'Functional + Lower Body', 'training_date' => '2026-09-17 18:00:00', 'duration_min' => 60, 'trainer_name' => 'Анастасія Білоус', 'capacity' => 8, 'booked' => 8, 'rating' => '4.9'],
    ['id' => 3, 'title' => 'Фітнес', 'training_date' => '2026-09-17 17:00:00', 'duration_min' => 60, 'trainer_name' => 'Катерина Романюк', 'capacity' => 12, 'booked' => 5, 'rating' => '4.9']
];

function formatTimeOnly(string $dateTimeStr): string {
    $timestamp = strtotime($dateTimeStr);
    return date('H:i', $timestamp);
}

function formatDateOnly(string $dateTimeStr): string {
    $timestamp = strtotime($dateTimeStr);
    return date('d.m.Y', $timestamp);
}
?>

<div class="container-fluid py-4 px-lg-5 bg-light min-vh-100">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3 border-0 shadow-sm">
            ✨ <?= htmlspecialchars($_SESSION['flash_success']) ?>
            <?php unset($_SESSION['flash_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($isAdmin): ?>
        <div class="d-flex justify-content-end mb-4">
            <a href="index.php?route=trainings/create" class="btn btn-danger px-4 rounded-pill fw-semibold">
                ➕ Додати тренування
            </a>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3 shadow-sm border overflow-hidden">
        <?php if (empty($trainings)): ?>
            <div class="text-center py-5 text-muted">
                <h5>Розклад порожній</h5>
            </div>
        <?php else: ?>
            <div class="training-list">
                <?php foreach ($trainings as $item): 
                    $itemId = (int)$item['id'];
                    $time = formatTimeOnly($item['training_date']);
                    $date = formatDateOnly($item['training_date']);
                    
                    $isBookedByMe = in_array($itemId, $_SESSION['user_bookings']);

                    $booked = (int)($item['booked'] ?? 0) + ($isBookedByMe ? 1 : 0); 
                    $capacity = (int)$item['capacity'];
                    $available = $capacity - $booked;

                    if ($available < 0) $available = 0;
                    $isFull = $available <= 0;

                    $rating = $item['rating'] ?? '4.9';
                ?>
                    <div class="training-row-custom border-bottom">
                        
                        <div class="training-info-group">
                            <div class="time-item d-flex flex-column justify-content-center">
                                <span class="fw-bold fs-5 text-dark lh-1"><?= $time ?></span>
                                <span class="text-muted small mt-1" style="font-size: 12px;"><?= $date ?></span>
                            </div>

                            <div class="title-item fw-bold text-dark fs-6">
                                <?= htmlspecialchars($item['title']) ?>
                                <span class="rating-span fw-normal text-dark">⭐ <?= $rating ?></span>
                            </div>

                            <div class="duration-item text-muted small">
                                🕒 <?= (int)$item['duration_min'] ?> хвилин
                            </div>

                            <div class="trainer-item text-dark small">
                                🧘 <?= htmlspecialchars($item['trainer_name']) ?>
                            </div>
                        </div>
                        <div class="training-action-group">
                            <div class="tooltip-hover-container d-none d-sm-block">
                                <div class="d-flex gap-1" style="cursor: pointer;">
                                    <?php 
                                    $fillPercent = $capacity > 0 ? ($booked / $capacity) : 0;
                                    $activeBars = (int)ceil($fillPercent * 5);
                                    for ($i = 1; $i <= 5; $i++): 
                                    ?>
                                        <span class="bar-segment <?= $i <= $activeBars ? 'active' : '' ?>"></span>
                                    <?php endfor; ?>
                                </div>
                                <div class="custom-tooltip-popup">
                                    <div class="text-secondary small mb-1">Зайнято місць: <b><?= $booked ?></b> з <?= $capacity ?></div>
                                    <div class="text-danger small fw-normal mb-1">Залишилось вільних:</div>
                                    <div class="fw-bold text-dark fs-5"><?= $available ?> <span class="text-muted fs-6">/ <?= $capacity ?></span></div>
                                </div>
                            </div>
                            <div class="tooltip-hover-container">
                                <?php if ($isAdmin): ?>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="index.php?route=trainings/edit&id=<?= $itemId ?>" class="btn btn-sm btn-outline-warning rounded-2">
                                            ✏️
                                        </a>
                                        <a href="index.php?route=trainings/delete&id=<?= $itemId ?>" class="btn btn-sm btn-outline-danger rounded-2" onclick="return confirm('Видалити?');">
                                            🗑️
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <?php if ($isBookedByMe): ?>
                                        <a href="index.php?route=trainings&action=unbook&id=<?= $itemId ?>" 
                                           class="btn btn-booked-cancel py-2 px-3 fw-semibold text-uppercase small"
                                           onclick="return confirm('Ви дійсно бажаєте скасувати запис?');">
                                            <span class="btn-text-default">✓ Ви записані</span>
                                            <span class="btn-text-hover">✕ Скасувати</span>
                                        </a>
                                    <?php elseif ($isFull): ?>
                                        <button class="btn btn-secondary py-2 px-3 fw-semibold text-uppercase small" disabled>
                                            Зайнято
                                        </button>
                                    <?php else: ?>
                                        <a href="index.php?route=trainings&action=book&id=<?= $itemId ?>" 
                                           class="btn btn-pink py-2 px-4 fw-semibold text-white text-uppercase small">
                                            Записатися
                                        </a>
                                    <?php endif; ?>

                                    <div class="custom-tooltip-popup">
                                        <div class="text-danger small fw-normal mb-1">Залишилось місць:</div>
                                        <div class="fw-bold text-dark fs-5"><?= $available ?> <span class="text-muted fs-6">/ <?= $capacity ?></span></div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.training-row-custom {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    width: 100% !important;
    padding: 16px 24px;
    box-sizing: border-box;
    transition: background-color 0.2s ease;
}

.training-row-custom:hover {
    background-color: #f8f9fa;
}

.training-info-group {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 32px;
    flex-wrap: nowrap;
}

.time-item { min-width: 75px; }

.title-item {
    min-width: 200px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rating-span {
    font-size: 14px;
    white-space: nowrap;
}

.duration-item {
    min-width: 100px;
    white-space: nowrap;
}

.trainer-item {
    min-width: 160px;
    white-space: nowrap;
}

.training-action-group {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 20px;
    margin-left: auto !important;
}
.btn-pink {
    background-color: #e31255;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: background-color 0.2s ease;
    white-space: nowrap;
    display: inline-block;
}

.btn-pink:hover {
    background-color: #c40e47;
    color: #fff;
}

.btn-booked-cancel {
    background-color: #198754;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: all 0.2s ease;
    white-space: nowrap;
    display: inline-block;
    min-width: 135px;
    text-align: center;
    text-decoration: none;
}

.btn-booked-cancel .btn-text-hover {
    display: none;
}

.btn-booked-cancel:hover {
    background-color: #dc3545;
    color: #ffffff;
}

.btn-booked-cancel:hover .btn-text-default {
    display: none;
}

.btn-booked-cancel:hover .btn-text-hover {
    display: inline;
}

.bar-segment {
    width: 20px;
    height: 6px;
    background-color: #e2e8f0;
    border-radius: 2px;
    display: inline-block;
}

.bar-segment.active {
    background-color: #38bdf8;
}

.tooltip-hover-container {
    position: relative;
    display: inline-block;
}

.custom-tooltip-popup {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-8px);
    background-color: #ffffff;
    color: #333333;
    padding: 8px 16px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border: 1px solid #f0f0f0;
    white-space: nowrap;
    text-align: center;
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
}

.custom-tooltip-popup::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: #ffffff transparent transparent transparent;
}

.tooltip-hover-container:hover .custom-tooltip-popup {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-12px);
}
</style>