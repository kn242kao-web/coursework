<?php

class GuestbookController extends PageController
{
    private string $filePath = 'data/guestbook.json';

    public function action_main(): void
    {
        $this->action_index();
    }

    public function action_index(): void
    {
        date_default_timezone_set('Europe/Kyiv');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateReview($_POST);

            if (empty($errors)) {
                $author   = trim($_POST['author'] ?? $_POST['name'] ?? 'Гість');
                $text     = trim($_POST['text'] ?? $_POST['comment'] ?? $_POST['message'] ?? '');
                $training = trim($_POST['training_name'] ?? '');
                $rating   = (int)($_POST['rating'] ?? 5);

                if (!is_dir('data')) {
                    mkdir('data', 0777, true);
                }

                $comments = $this->loadComments();

                array_unshift($comments, [
                    'author'   => htmlspecialchars($author),
                    'training' => htmlspecialchars($training),
                    'rating'   => $rating,
                    'text'     => htmlspecialchars($text),
                    'date'     => date('d.m.Y H:i')
                ]);

                file_put_contents(
                    $this->filePath, 
                    json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );
            }

            header('Location: index.php?route=guestbook');
            exit;
        }

        $trainingsList = ['Pilates', 'Functional + Lower Body', 'Фітнес', 'Йога', 'Stretching'];

        $this->render('guestbook/index', [
            'comments'  => $this->loadComments(),
            'trainings' => $trainingsList
        ], 'Відгуки про GymMaster');
    }

    private function validateReview(array $data): array
    {
        $errors = [];

        $text     = trim($data['text'] ?? $data['comment'] ?? $data['message'] ?? '');
        $training = trim($data['training_name'] ?? '');
        $rating   = (int)($data['rating'] ?? 0);

        if (empty($text)) {
            $errors['text'] = 'Введіть текст відгуку.';
        }

        if (empty($training)) {
            $errors['training'] = 'Оберіть тренування зі списку.';
        }

        if ($rating < 1 || $rating > 5) {
            $errors['rating'] = 'Оцінка повинна бути від 1 до 5.';
        }

        return $errors;
    }

    private function loadComments(): array
    {
        if (file_exists($this->filePath)) {
            $jsonContent = file_get_contents($this->filePath);
            return json_decode($jsonContent, true) ?? [];
        }

        return [];
    }
}