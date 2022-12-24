<?php




use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
//define directory global static variable
$app = new Application(dirname(__DIR__), $config);
//define the routes
//home
$app->router->get('/', [SiteController::class, 'home']);
//contact
$app->router->get('/contact', [SiteController::class, 'renderView']);
$app->router->post('/contact', [SiteController::class, 'contact']);
//login post and get
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
// register post and get
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);


//run the app
$app->run();