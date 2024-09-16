<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__.'/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if (!isset($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])) {
    throw new Exception('Database configuration is incomplete.');
}


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);
$siteController = new SiteController();
$authController = new AuthController();

// Define routes
$app->router->get('/', [$siteController, 'home']);
$app->router->get('/contact', [$siteController, 'contact']);
$app->router->post('/contact', [$siteController, 'handleContact']);

$app->router->get('/login', [$authController, 'login']);
$app->router->post('/login', [$authController, 'login']);

$app->router->get('/register', [$authController, 'register']);
$app->router->post('/register', [$authController, 'register']);

// Run the application
$app->run();