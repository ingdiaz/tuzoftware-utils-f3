<?php

namespace Core\Base;

require 'vendor/autoload.php';
class ValidatorUtil{

    private $validator;


    public function addValidationArray($validationArray){
        $this->validator = new Valitron\Validator($validationArray);
    }

    public function spaceText($array,$field){
        $v = new Valitron\Validator($array);
        $v->rule('required', $field);
        if(!$v->validate()) {
            $v->errors();
        }
        return true;
    }

    public function  validateText($field, $required, $minLong, $maxLong, $regularExpression=''){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $minLong,$maxLong);
        if(!empty($regularExpression)){
            $this->validator->rule('regex',$field,$regularExpression);
        }
    }

    public function validateNumeric($field, $required, $minValue, $maxValue){
        $this->validateRequired($field,$required);
        $this->validator->rule("numeric",$field);
        $this->validator->rule('between', $field, array($minValue, $maxValue));
    }

    public function validateNumericId($field, $required, $minValue){
        $this->validateRequired($field,$required);
        $this->validator->rule("integer",$field);
        $this->validator->rule('min', $field, $minValue);
    }

    private function validateRequired($field, $required){
        if($required){
            $this->validator->rule("required",$field);
        }
    }

    public function validate(){
        if(!$this->validator->validate()) {
            header('Content-Type: application/json');
            echo json_encode($this->validator->errors());
            exit;
        }
        return true;
    }
    public function validatePassword($field, $required, $minLong, $maxLong){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $minLong,$maxLong);
        $this->validator->rule('alphaNum',$field);
    }
    public function validateCurp($field, $required, $minLong, $maxLong){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $minLong,$maxLong);
        $this->validator->rule('alphaNum',$field);
    }
    public function validateEmail($field, $required, $minLong, $maxLong)
    {
        $this->validateRequired($field, $required);
        $this->validator->rule('lengthBetween', $field, $minLong, $maxLong);
        $this->validator->rule('email', $field);

    }

}