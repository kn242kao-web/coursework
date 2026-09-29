<?php

class TrainingsController extends PageController 
{
    private string $dataFile = 'data/trainings.json';

    public function __construct()
    {
        parent::__construct();
        
        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }

        if (!file_exists($this->dataFile)) {
            $initialData = [
                [
                    'id' => 1,
                    'title' => 'Pilates',
                    'trainer_name' => 'Владислава Александрова',
                    'training_date' => date('Y-m-d') . 'T17:00',
                    'duration_min' => 60,
                    'capacity' => 34,
                    'booked' => 0
                ],
                [
                    'id' => 2,
                    'title' => 'Functional + Lower Body',
                    'trainer_name' => 'Анастасія Білоус',
                    'training_date' => date('Y-m-d') . 'T18:00',
                    'duration_min' => 60,
                    'capacity' => 20,
                    'booked' => 0
                ]
            ];
            file_put_contents($this->dataFile, json_encode($initialData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
    }

    private function checkIsAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($_SESSION['is_admin']) 
            || !empty($_SESSION['user']['is_admin']) 
            || (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
    }

    private function getTrainings(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $json = file_get_contents($this->dataFile);
        return json_decode($json, true) ?? [];
    }

    private function saveTrainings(array $trainings): void
    {
        file_put_contents($this->dataFile, json_encode($trainings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public function action_main(): void 
    {
        $this->action_list();
    }

    public function action_list(): void 
    {
        $trainings = $this->getTrainings();

        usort($trainings, fn($a, $b) => strcmp($a['training_date'], $b['training_date']));

        $this->render('trainings/list', [
            'trainings' => $trainings,
            'isAdmin'   => $this->checkIsAdmin()
        ], 'Розклад тренувань');
    }

    public function action_create(): void 
    {
        if (!$this->checkIsAdmin()) {
            header("Location: index.php?route=trainings/list");
            exit;
        }

        $error = '';

        if ($this->request->isPost()) {
            $title = trim($_POST['title'] ?? '');
            $trainer_name = trim($_POST['trainer_name'] ?? '');
            $training_date = trim($_POST['training_date'] ?? '');
            $duration_min = (int)($_POST['duration_min'] ?? 0);
            $capacity = (int)($_POST['capacity'] ?? 0);

            if ($title && $trainer_name && $training_date && $duration_min && $capacity) {
                $trainings = $this->getTrainings();
                
                $trainings[] = [
                    'id' => time(),
                    'title' => $title,
                    'trainer_name' => $trainer_name,
                    'training_date' => $training_date,
                    'duration_min' => $duration_min,
                    'capacity' => $capacity,
                    'booked' => 0
                ];

                $this->saveTrainings($trainings);

                $_SESSION['flash_success'] = "Тренування успішно додано до розкладу!";
                header("Location: index.php?route=trainings/list");
                exit;
            } else {
                $error = "Будь ласка, заповніть усі поля форми!";
            }
        }

        $this->render('trainings/create', [
            'error' => $error
        ], 'Додати тренування');
    }

    public function action_edit(): void 
    {
        if (!$this->checkIsAdmin()) {
            header("Location: index.php?route=trainings/list");
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $trainings = $this->getTrainings();
        $targetIndex = null;
        $training = null;

        foreach ($trainings as $index => $item) {
            if ((int)$item['id'] === $id) {
                $targetIndex = $index;
                $training = $item;
                break;
            }
        }

        if ($training === null) {
            header("Location: index.php?route=trainings/list");
            exit;
        }

        $error = '';

        if ($this->request->isPost()) {
            $title = trim($_POST['title'] ?? '');
            $trainer_name = trim($_POST['trainer_name'] ?? '');
            $training_date = trim($_POST['training_date'] ?? '');
            $duration_min = (int)($_POST['duration_min'] ?? 0);
            $capacity = (int)($_POST['capacity'] ?? 0);

            if ($title && $trainer_name && $training_date && $duration_min && $capacity) {
                $trainings[$targetIndex] = [
                    'id' => $id,
                    'title' => $title,
                    'trainer_name' => $trainer_name,
                    'training_date' => $training_date,
                    'duration_min' => $duration_min,
                    'capacity' => $capacity,
                    'booked' => $training['booked'] ?? 0
                ];

                $this->saveTrainings($trainings);

                $_SESSION['flash_success'] = "Зміни збережено!";
                header("Location: index.php?route=trainings/list");
                exit;
            } else {
                $error = "Всі поля мають бути заповнені!";
            }
        }

        $this->render('trainings/edit', [
            'training' => $training,
            'error' => $error
        ], 'Редагувати тренування');
    }

    public function action_delete(): void 
    {
        if ($this->checkIsAdmin()) {
            $id = (int)($_GET['id'] ?? 0);
            $trainings = $this->getTrainings();

            $filtered = array_filter($trainings, fn($item) => (int)$item['id'] !== $id);
            $this->saveTrainings(array_values($filtered));

            $_SESSION['flash_success'] = "Тренування видалено!";
        }

        header("Location: index.php?route=trainings/list");
        exit;
    }

    public function action_book(): void 
    {
        $id = (int)($_GET['id'] ?? 0);
        $trainings = $this->getTrainings();

        foreach ($trainings as &$item) {
            if ((int)$item['id'] === $id) {
                if (!isset($item['booked'])) {
                    $item['booked'] = 0;
                }

                if ($item['booked'] < $item['capacity']) {
                    $item['booked']++;
                    $_SESSION['flash_success'] = "Ви успішно записалися на тренування \"{$item['title']}\"!";
                } else {
                    $_SESSION['flash_error'] = "На жаль, усі місця на це тренування вже зайняті.";
                }
                break;
            }
        }

        $this->saveTrainings($trainings);

        header("Location: index.php?route=trainings/list");
        exit;
    }
}