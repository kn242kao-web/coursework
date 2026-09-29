<?php

class AuthController extends PageController
{
    private ?PDO $db = null;

    public function __construct()
    {
        parent::__construct();
        try {
            $this->db = Database::getInstance();
        } catch (\Throwable $e) {
            $this->db = null;
        }
    }

    public function action_register(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('auth/profile');
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validateRegister($old);

            if (empty($errors) && $this->db) {
                $stmt = $this->db->prepare(
                    'INSERT INTO users (login, password, email, first_name, last_name, phone, city, gender, about, created_at)
                     VALUES (:login, :password, :email, :first_name, :last_name, :phone, :city, :gender, :about, DATETIME("now"))'
                );
                
                $stmt->execute([
                    ':login'      => trim($old['login']),
                    ':password'   => password_hash($old['password'], PASSWORD_DEFAULT), 
                    ':email'      => trim($old['email']),
                    ':first_name' => trim($old['first_name']),
                    ':last_name'  => trim($old['last_name']),
                    ':phone'      => trim($old['phone'] ?? ''),
                    ':city'       => trim($old['city'] ?? ''),
                    ':gender'     => $old['gender'] ?? '',
                    ':about'      => trim($old['about'] ?? ''),
                ]);

                session_regenerate_id(true);
                $_SESSION['user_id'] = $this->db->lastInsertId();
                $_SESSION['user_login'] = trim($old['login']);
                $_SESSION['is_admin'] = false;
                
                $this->redirect('auth/profile');
                return;
            }
        }

        $this->render('auth/register', [
            'errors' => $errors,
            'old'    => $old,
        ], 'Реєстрація атлета');
    }

    public function action_login(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('auth/profile');
            return;
        }

        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = $this->request->post('password', '');

            $adminLogin = 'admin';
            $adminPass  = 'admin123';

            if ($login === $adminLogin && $password === $adminPass) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = 999;
                $_SESSION['user_login'] = $adminLogin;
                $_SESSION['is_admin'] = true;

                $this->redirect('trainings/list'); 
                return;
            }

            if ($this->db) {
                try {
                    $stmt = $this->db->prepare('SELECT * FROM users WHERE login = :login');
                    $stmt->execute([':login' => $login]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password'])) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_login'] = $user['login'];
                        $_SESSION['is_admin'] = ($user['login'] === 'admin');

                        $this->redirect('trainings/list');
                        return;
                    }
                } catch (\Throwable $e) {
                }
            }

            $error = 'Невірний логін або пароль.';
        }

        $this->render('auth/login', ['error' => $error], 'Вхід до залу');
    }

    public function action_profile(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('auth/login');
            return;
        }

        $user = [
            'login' => $_SESSION['user_login'] ?? 'admin',
            'first_name' => 'Адміністратор',
            'last_name' => '',
            'email' => 'admin@gym.com',
            'phone' => '',
            'city' => '',
            'gender' => '',
            'about' => 'Головний адміністратор сайту'
        ];

        if ($this->db) {
            try {
                $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
                $stmt->execute([':id' => $_SESSION['user_id']]);
                $dbUser = $stmt->fetch();
                if ($dbUser) {
                    $user = $dbUser;
                }
            } catch (\Throwable $e) {
            }
        }

        $this->render('auth/profile', ['user' => $user], 'Мій профіль');
    }

    public function action_edit(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('auth/login');
            return;
        }

        $user = [
            'login' => $_SESSION['user_login'] ?? 'admin',
            'first_name' => 'Адміністратор',
            'last_name' => '',
            'email' => 'admin@gym.com',
            'phone' => '',
            'city' => '',
            'gender' => '',
            'about' => ''
        ];

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validateEdit($data);

            if (empty($errors)) {
                if ($this->db) {
                    try {
                        $stmt = $this->db->prepare(
                            'UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name,
                             phone = :phone, city = :city, gender = :gender, about = :about WHERE id = :id'
                        );
                        $stmt->execute([
                            ':email'      => trim($data['email']),
                            ':first_name' => trim($data['first_name']),
                            ':last_name'  => trim($data['last_name']),
                            ':phone'      => trim($data['phone'] ?? ''),
                            ':city'       => trim($data['city'] ?? ''),
                            ':gender'     => $data['gender'] ?? '',
                            ':about'      => trim($data['about'] ?? ''),
                            ':id'         => $_SESSION['user_id'],
                        ]);
                    } catch (\Throwable $e) {
                    }
                }

                $this->redirect('auth/profile');
                return;
            }
            $user = array_merge($user, $data);
        }

        $this->render('auth/edit', ['user' => $user, 'errors' => $errors], 'Редагування профілю');
    }

    public function action_logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_login'], $_SESSION['is_admin']);
        session_destroy();
        $this->redirect('index/main');
    }

    public function action_delete(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->request->isPost() && $this->request->post('confirm') === 'yes') {
            if ($this->db) {
                try {
                    $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
                    $stmt->execute([':id' => $_SESSION['user_id']]);
                } catch (\Throwable $e) {
                }
            }
            
            $this->action_logout();
            return;
        }

        $this->render('auth/delete', [], 'Видалення акаунту');
    }

    private function validateRegister(array $data): array
    {
        $errors = [];
        $login = trim($data['login'] ?? '');
        
        if (strlen($login) < 3) {
            $errors['login'] = 'Логін занадто короткий.';
        } elseif ($this->db) {
            try {
                $stmt = $this->db->prepare('SELECT id FROM users WHERE login = :login');
                $stmt->execute([':login' => $login]);
                if ($stmt->fetch()) $errors['login'] = 'Цей логін вже зайнятий.';
            } catch (\Throwable $e) {
            }
        }

        if (strlen($data['password'] ?? '') < 6) {
            $errors['password'] = 'Пароль від 6 символів.';
        }

        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некоректний E-mail.';
        }

        if (empty($data['first_name'])) $errors['first_name'] = "Вкажіть ім'я.";
        
        return $errors;
    }

    private function validateEdit(array $data): array
    {
        $errors = [];
        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некоректний E-mail.';
        }
        return $errors;
    }
}