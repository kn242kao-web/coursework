<?php
class UploadController extends PageController {
    public function action_index(): void {
        if ($this->request->isPost() && isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowed) && $file['size'] <= 5*1024*1024) {
                $newName = time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($file['tmp_name'], DATA_DIR . "/uploads/" . $newName);
                $_SESSION['flash_success'] = "Фото додано!";
            } else {
                $_SESSION['flash_error'] = "Помилка: файл завеликий або не той формат.";
            }
            header("Location: index.php?controller=upload&action=index");
            exit;
        }

        $files = glob(DATA_DIR . "/uploads/*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
        $images = array_map(fn($f) => [
            'url' => 'data/uploads/' . basename($f),
            'name' => basename($f),
            'size' => filesize($f),
            'date' => date("d.m.Y", filemtime($f))
        ], $files);

        $this->render('upload/index', ['images' => $images], 'Галерея залу');
    }
}