<?php

namespace app\core;

use app\controllers\Controller;

class Application
{

// router instance
    public Router $router;
    public Database $db;
//    request instance
    public Request $request;
//    response instance
    public Response $response;
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
    self::$app = $this;
    self::$ROOT_DIR = $rootPath;
    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
    $this->db = new Database($config['db']);
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
}