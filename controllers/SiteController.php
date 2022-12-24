<?php
namespace app\controllers;
use app\controllers\Controller;
use app\core\Request;

class SiteController extends Controller
{

    public static function renderView() {
//        render application view
        return self::render('contact');
    }

    public static function home() {
        $params = [
            'name' => 'Mohammed'
        ];
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