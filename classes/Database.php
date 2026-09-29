<?php

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require ROOT_DIR . '/config/database.php';
            try {
                self::$instance = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                die("Помилка з'єднання з базою даних: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}