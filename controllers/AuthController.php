<?php

namespace app\controllers;

use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{

    public function login() {
        return self::render('login');
    }


    public function register(Request $request) {
        $this->setLayout('main');

        $registerModel = new RegisterModel();

        if($request->isPost()) {
            $registerModel->loadData($request->getBody());

            if($registerModel->validate() && $registerModel->register()){
//                $errors['firstName'] = 'This field is required';
                return 'success';
            }
            return self::render('register', [
                'model'=> $registerModel
            ]);
        }



        return self::render('register', [
            'model'=> $registerModel
        ]);
    }

}