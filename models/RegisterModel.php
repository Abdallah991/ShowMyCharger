<?php

namespace app\models;
use app\core\Model;

class RegisterModel extends Model
{
    public string $firstName ='';
    public string $lastName ='';
    public string $email ='';
    public string $password ='';
    public string $confirmPassword ='';

    public function register() {
        return 'creating new user';
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'firstName' =>[self::RULE_REQUIRED],
            'lastName' =>[self::RULE_REQUIRED],
            'email' =>[self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
            'password' =>[self::RULE_REQUIRED],
            'confirmPassword' =>[self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']],
        ];
    }

}