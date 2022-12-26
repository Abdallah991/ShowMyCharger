<?php
namespace app\controllers;
use app\controllers\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;

class SiteController extends Controller
{

    public static function renderView() {
//        render application view
        return self::render('contact');
    }

    public static function home(Request $request, Response $response) {
        $params = [

        ];

        if(!Application::$app->user) {
             $params = [
                 'name' => Application::$app->user->firstName

             ];
        } else {
            $params = [
                'name' => 'Guest'

            ];
        }

        
//        render application view
        return self::render('home', $params);
    }

    public static function contact() {
        return 'Contact';
    }

//    handle submitted data
    public static function postForm(Request $request) {
        $body = $request->getBody($request);
//        return self::render('contact', $params);
    }



}