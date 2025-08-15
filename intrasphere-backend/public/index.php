<?php
// IntraSphere PHP Backend - Point d'entrée API

// Charger l'autoload
require_once __DIR__ . '/../api/Config/Router.php'; // La classe routeur
require_once __DIR__ . '/../api/Config/Response.php'; // Réponses standard
require_once __DIR__ . '/../api/Config/Database.php'; // PDO

// Charger les routes définies
require_once __DIR__ . '/../api/routes.php'; // ici, vous collez le contenu définitif

// Initialiser le router
$router = new Router();

// Définir les routes (copiez-collez le contenu de `routes.php` ici, sans modification)

// ... (voir contenu routes.php fourni dans les étapes précédentes) ...

// Dispatch la requête
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    Response::error($e->getMessage(), 500);
}