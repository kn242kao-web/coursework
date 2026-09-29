<?php

class FolderController extends PageController {
    
    public function action_create(): void {
        $message = ''; 
        $error = '';
        
        $baseDir = __DIR__ . '/../data/users';
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        if ($this->request->isPost()) {
            $login = preg_replace('/[^a-z0-9_]/i', '', $_POST['login'] ?? '');
            $path = $baseDir . "/$login";

            if (empty($login)) {
                $error = "Логін не може бути порожнім!";
            } elseif (is_dir($path)) {
                $error = "Атлет з таким логіном вже має каталог!";
            } else {
                if (mkdir($path, 0777, true)) {
                    foreach (['video', 'music', 'photo'] as $sub) {
                        mkdir("$path/$sub", 0777, true);
                        file_put_contents("$path/$sub/info.txt", "Каталог $sub для $login");
                    }
                    $message = "Каталог для $login успішно створено!";
                } else {
                    $error = "Не вдалося створити каталог на сервері!";
                }
            }
        }

        $folders = [];
        if (is_dir($baseDir)) {
            $dirs = scandir($baseDir);
            foreach ($dirs as $dir) {
                if ($dir !== '.' && $dir !== '..' && is_dir("$baseDir/$dir")) {
                    $subfolders = [];
                    foreach (['video', 'music', 'photo'] as $sub) {
                        $subPath = "$baseDir/$dir/$sub";
                        $filesCount = is_dir($subPath) ? count(array_diff(scandir($subPath), ['.', '..'])) : 0;
                        $subfolders[] = [
                            'name' => $sub,
                            'files' => $filesCount
                        ];
                    }
                    $folders[] = [
                        'name' => $dir,
                        'subfolders' => $subfolders
                    ];
                }
            }
        }

        $this->render('folder/create', [
            'message' => $message, 
            'error' => $error,
            'folders' => $folders
        ], 'Робота з каталогами');
    }

    public function action_delete(): void {
        $message = '';
        $error = '';
        $baseDir = __DIR__ . '/../data/users';

        if ($this->request->isPost()) {
            $login = preg_replace('/[^a-z0-9_]/i', '', $_POST['login'] ?? '');
            $path = $baseDir . "/$login";
            
            if (empty($login)) {
                $error = "Введіть логін для видалення!";
            } elseif (!is_dir($path)) {
                $error = "Каталог для '$login' не знайдено!";
            } else {
                $this->rrmdir($path);
                $message = "Каталог '$login' успішно видалено!";
            }
        }

        $this->render('folder/delete', ['message' => $message, 'error' => $error], 'Видалення каталогу');
    }

    private function rrmdir($dir): void {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}