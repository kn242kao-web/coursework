<?php

session_start([
    'cookie_httponly' => true, 
    'cookie_samesite' => 'Lax'
]);

define('ROOT_DIR', dirname(__DIR__));
define('CLASSES_DIR', ROOT_DIR . '/classes');
define('CONTROLLERS_DIR', ROOT_DIR . '/controllers');
define('VIEWS_DIR', ROOT_DIR . '/views');
define('DATA_DIR', ROOT_DIR . '/data'); 
define('DATABASE_DIR', ROOT_DIR . '/database'); 

spl_autoload_register(function (string $className): void {
    $paths = [
        CLASSES_DIR . '/' . $className . '.php',     
        CONTROLLERS_DIR . '/' . $className . '.php', 
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$requiredFolders = [
    DATA_DIR . '/uploads', 
    DATA_DIR . '/users', 
    DATA_DIR . '/gallery',  
    DATABASE_DIR           
];

foreach ($requiredFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}