<?php
class TrainingsController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_list(): void
    {
        $stmt = $this->db->query('SELECT * FROM trainings ORDER BY training_date ASC');
        $trainings = $stmt->fetchAll();

        $this->render('trainings/list', [
            'trainings' => $trainings,
        ], 'Розклад тренувань');
    }

    public function action_create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth', 'login');
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO trainings (title, trainer_name, training_date, duration_min, capacity, description)
                     VALUES (:title, :trainer_name, :training_date, :duration_min, :capacity, :description)'
                );
                $stmt->execute([
                    ':title'         => trim($old['title']),
                    ':trainer_name'  => trim($old['trainer_name']),
                    ':training_date' => $old['training_date'],
                    ':duration_min'  => (int)$old['duration_min'],
                    ':capacity'      => (int)$old['capacity'],
                    ':description'   => trim($old['description'] ?? ''),
                ]);

                $this->redirect('trainings', 'list');
                return;
            }
        }

        $this->render('trainings/create', [
            'errors' => $errors,
            'old'    => $old,
        ], 'Додати тренування');
    }

    public function action_edit(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth', 'login');
            return;
        }

        $id = (int)$this->request->get('id', 0);
        
        $stmt = $this->db->prepare('SELECT * FROM trainings WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $training = $stmt->fetch();

        if (!$training) {
            $this->redirect('trainings', 'list');
            return;
        }

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validate($data);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'UPDATE trainings SET title = :title, trainer_name = :trainer_name, 
                     training_date = :training_date, duration_min = :duration_min, 
                     capacity = :capacity, description = :description WHERE id = :id'
                );
                $stmt->execute([
                    ':title'         => trim($data['title']),
                    ':trainer_name'  => trim($data['trainer_name']),
                    ':training_date' => $data['training_date'],
                    ':duration_min'  => (int)$data['duration_min'],
                    ':capacity'      => (int)$data['capacity'],
                    ':description'   => trim($data['description'] ?? ''),
                    ':id'            => $id,
                ]);

                $this->redirect('trainings', 'list');
                return;
            }
            $training = array_merge($training, $data);
        }

        $this->render('trainings/edit', [
            'training' => $training,
            'errors'   => $errors,
        ], 'Редагувати заняття');
    }

    public function action_delete(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth', 'login');
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);
            if ($id > 0) {
                $stmt = $this->db->prepare('DELETE FROM trainings WHERE id = :id');
                $stmt->execute([':id' => $id]);
            }
        }

        $this->redirect('trainings', 'list');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (trim($data['title'] ?? '') === '') {
            $errors['title'] = 'Назва тренування обов’язкова.';
        }
        if (trim($data['trainer_name'] ?? '') === '') {
            $errors['trainer_name'] = 'Вкажіть ім’я тренера.';
        }
        
        $duration = $data['duration_min'] ?? 0;
        if ((int)$duration <= 0) {
            $errors['duration_min'] = 'Тривалість має бути більше 0.';
        }

        $capacity = $data['capacity'] ?? 0;
        if ((int)$capacity < 1) {
            $errors['capacity'] = 'Мінімальна кількість місць — 1.';
        }

        return $errors;
    }
}