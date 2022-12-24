<?php

namespace app\core;


abstract class Model
{

    public array $errors=[];
    public const RULE_REQUIRED = 'required';
    public const RULE_UNIQUE = 'unique';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';

    public function loadData($data) {

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

    }

    abstract public function rules():array;
    public function validate(){

        foreach ($this->rules() as $attribute=>$rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);

                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH);

                }

            }

        }

        return empty($this->errors);

    }

    public function addError($attribute, $rule, $params=[]){

        $message = $this->errorMessages()[$rule]?? '';
        foreach ($params as $key=>$value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
}

public function errorMessages() {

        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email',
            self::RULE_UNIQUE => 'This email is registered in the system',
            self::RULE_MATCH => 'This password must match',
        ];

}

public function hasError($attribute) {
       return  $this->errors[$attribute]?? false;
}

public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
}



}