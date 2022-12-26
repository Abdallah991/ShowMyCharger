<?php

namespace app\core\forms;

use app\core\Model;

class Form
{

    public static function begin($action, $method) {
        echo sprintf('<form action="%s" method="%s" novalidate>', $action, $method);
        return new Form();
}

    public static function end() {
        echo '</form>';
    }

    public  function field(Model $model, $attribute) {
        return new Field($model, $attribute);
    }



}