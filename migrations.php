<?php


use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ .'/vendor/autoload.php';
//this is a comment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
//define directory global static
$app = new Application(__DIR__, $config);

//run the app
$app->db->applyMigration();
