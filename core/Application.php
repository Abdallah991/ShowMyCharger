<?php

namespace app\core;

use app\controllers\Controller;
use app\models\User;

class Application
{

    public string $userClass;
// router instance
    public Router $router;
    public Database $db;
//    request instance
    public Request $request;
//    response instance
    public Response $response;
    public DbModel $user;
    public Session $session;
//    app static instance
    public static Application $app;
//    static directory address
    public static string $ROOT_DIR;
//    controller instance
    public Controller $controller;
//    constructor with path passed into it
public function __construct($rootPath, array $config)
{
//    set app, root, request, response, router instance
    $this->userClass = $config['userClass'];
    self::$app = $this;
    $this->user = new User();
    self::$ROOT_DIR = $rootPath;
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Session();
    $this->router = new Router($this->request, $this->response);
    $this->db = new Database($config['db']);

    $primaryValue = $this->session->get('user');

    if ($primaryValue) {
        $primaryKey = $this->userClass::primaryKey();
        $this->user = $this->userClass::findOne([$primaryKey=> $primaryValue ]);

    }else {

//        $this->user = null;
    }
}

public static function isGuest(): bool
{

    return !self::$app->user;
}



//run will run the resolve function in the router class
    public function run() {
    echo $this->router->resolve();

    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user): bool
    {

        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;

    }

    public function logout() {

        $this->user = null;
        $this->session->remove('user');
        return true;



    }
}