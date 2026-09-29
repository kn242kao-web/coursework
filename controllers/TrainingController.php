<?php
class TrainingController {
    public function action_index() {
        $db = Database::getInstance();

        $search = trim((string)($_GET['search'] ?? ''));
        $trainer = trim((string)($_GET['trainer'] ?? ''));
        $sort = trim((string)($_GET['sort'] ?? 'newest'));

        $sql = 'SELECT id, title, trainer_name, training_date, duration_min, capacity, description FROM trainings WHERE 1=1';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (title LIKE :search OR description LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }

        if ($trainer !== '') {
            $sql .= ' AND trainer_name = :trainer';
            $params[':trainer'] = $trainer;
        }

        switch ($sort) {
            case 'oldest':
                $sql .= ' ORDER BY training_date ASC, id ASC';
                break;
            case 'title':
                $sql .= ' ORDER BY title ASC';
                break;
            default:
                $sql .= ' ORDER BY training_date DESC, id DESC';
                break;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $trainings = $stmt->fetchAll();

        include 'views/training/index.php';
    }
}
?>