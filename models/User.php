<?php

namespace app\models;
use app\core\DbModel;
use app\core\UserModel;

class User extends UserModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public string $firstName ='';
    public string $lastName ='';
    public string $email ='';
    public string $password ='';
    public int $status =self::STATUS_INACTIVE;
    public string $confirmPassword ='';

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['firstName', 'lastName', 'email', 'password', ''];
    }

    public function save():bool {

        $this->status = self::STATUS_INACTIVE;
        $this->firstName ='';
        $this->lastName = '';

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
//            TODO: uncomment this
//            'firstName' =>[self::RULE_REQUIRED],
//            'lastName' =>[self::RULE_REQUIRED],
//            'email' =>[self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class'=>self::class]],
//            'password' =>[self::RULE_REQUIRED],
//            'confirmPassword' =>[self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']],
        ];
    }

    public function labels():array {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->firstName .' '.$this->lastName;
    }
}