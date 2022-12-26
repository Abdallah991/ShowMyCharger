<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\User;


class LoginForm extends Model
{

    public string $email = '';
    public string $password= '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_EMAIL, self::RULE_REQUIRED],
            'password' => [ self::RULE_REQUIRED],
        ];
    }

    public function login() {

        $user = User::findOne(['email' => $this->email]);

        if(!$user){
            $this->addError('email', 'User doesnt exist');
            return false;
        }

        if(!password_verify($this->password, $user->password)) {
            $this->addError('password', 'try another password');

        }

        return Application::$app->login($user);

    }

    public function labels():array {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}