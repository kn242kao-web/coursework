<?php
return [
    'dsn'      => 'sqlite:' . ROOT_DIR . '/database/gym_app.db',
    
    'username' => null,
    'password' => null,

    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ],
];