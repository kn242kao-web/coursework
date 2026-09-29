<?php
$trainings = $trainings ?? [];
?>

<h1>Розклад тренувань залу</h1>
<p>Поточний розклад групових та персональних занять. Зберігається та контролюється через PDO.</p>

<div class="form__actions" style="margin-bottom: 20px">
    <a href="index.php?route=trainings/create" class="btn">Додати тренування</a>
</div>

<?php if (empty($trainings)): ?>
    <p class="text-muted">Занять у розкладі поки немає.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва тренування</th>
                <th>Тренер</th>
                <th>Дата та час</th>
                <th>Тривалість</th>
                <th>Місць</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trainings as $t): ?>
                <tr>
                    <td><?= (int)$t['id'] ?></td>
                    <td><strong><?= htmlspecialchars($t['title']) ?></strong></td>
                    <td><?= htmlspecialchars($t['trainer_name']) ?></td>
                    <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($t['training_date']))) ?></td>
                    <td><?= (int)$t['duration_min'] ?> хв.</td>
                    <td><?= (int)$t['capacity'] ?> чол.</td>
                    <td class="table__actions">
                        <a href="index.php?route=trainings/edit&id=<?= (int)$t['id'] ?>" class="btn btn--small">Редагувати</a>
                        <a href="index.php?route=trainings/delete&id=<?= (int)$t['id'] ?>" 
                           class="btn btn--small btn--danger" 
                           onclick="return confirm('Видалити це тренування з розкладу?')">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>