<?php

namespace app\core;

class Router
{
//    define request, response and array instances
    public Request $request;
    public Response $response;

    protected array $routes=[];

    /**
     * @param Request $request
     * @param Response $response
     */
//    constructor accepts request value
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

//    get the router, get the path
    public function get($path, $callback) {

        $this->routes['get'][$path] = $callback;
    }
    //    get the router, get the path
    public function post($path, $callback) {

        $this->routes['post'][$path] = $callback;
    }



//    resolve function handles the response of the requested URL
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;


//        if path don't exist, return 404 error
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');

        }



//        render view if path exist
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
//        echo $callback;
        return call_user_func($callback, $this->request, $this->response);

    }

// render view by
    public function renderView($view, $params = []) {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
//        Rendering a view when selecting a route
//        replacing the content
        return str_replace('{{content}}',$viewContent, $layoutContent);
    }
    // render view by
    public function renderContent($viewContent) {
        $layoutContent = $this->layoutContent();
//        replacing the content
        return str_replace('{{content}}',$viewContent, $layoutContent);
    }

//    render content only inside main.php
    protected function layoutContent() {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();

    }

//    render view only requested through the URL
    public function renderOnlyView($view, $params) {
//        whenever we include values, these data is rendered as well
        foreach ($params as $key=> $value) {

            $$key = $value;

        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }





}