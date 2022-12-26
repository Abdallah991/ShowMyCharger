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
    public function validate():bool{

        foreach ($this->rules() as $attribute=>$rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }


                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED, array($rule));
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL, array($rule));

                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabels($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, array($rule));

                }

                if($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->db->pdo->prepare("
                    SELECT * FROM $tableName WHERE $uniqueAttribute= :attr");
//                    $this->addError($attribute, self::RULE_MATCH);
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if($record){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, array(['field' => $this->getLabels($attribute)]));

                    }


                }

            }

        }

        return empty($this->errors);

    }

    private function addErrorForRule($attribute, $rule, $params=[]){


        $message = $this->errorMessages()[$rule]?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}", "$value", $message);
        }
        $this->errors[$attribute][] = $message;
}

    public function addError($attribute, $message){

        $this->errors[$attribute][] = $message;
    }

public function errorMessages():array {

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



public function getLabels($attribute) {

        return $this->labels()[$attribute] ?? $attribute;

}



}