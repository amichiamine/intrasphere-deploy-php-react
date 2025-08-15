<?php
/** 
 * IntraSphere PHP Backend - Point d'entrée principal
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charger les variables d'environnement
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && !strpos(trim($line), '#') === 0) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Configuration des erreurs
if ($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Autoloader simple
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/api/Controllers/',
        __DIR__ . '/api/Models/',
        __DIR__ . '/api/Services/',
        __DIR__ . '/api/Middleware/',
        __DIR__ . '/api/Config/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Rediriger vers le dossier public
header('Location: /public/');
exit();