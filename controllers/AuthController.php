<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{

    public function login(Request $request, Response $response) {
        $loginForm = new LoginForm();
        if($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');
                return;
            }
        }

//        $this->setLayout('auth');

        return self::render('login', [
        'model' => $loginForm]);
    }

    public function logout(Request $request, Response $response) {
        Application::$app->logout();
        $response->redirect('/');
    }


    public function register(Request $request) {
//        $this->setLayout('main');

        $user = new User();

        if($request->method() === 'post') {
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()){
//                $errors['firstName'] = 'This field is required';
                Application::$app->session->setFlash('success', 'thanks for registering');
                Application::$app->response->redirect('/');
                return 'success';

            }


            return $this->render('register', [
                'model'=> $user
            ]);

        }

//        $this->setLayout('auth');
        return $this->render('register', [
            'model'=> $user
        ]);
    }

}