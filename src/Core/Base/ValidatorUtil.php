<?php

namespace Core\Base;

use Valitron\Validator;
Validator::langDir('vendor/vlucas/valitron/lang/validator_lang'); // always set langDir before lang.
Validator::lang('es');

require 'vendor/autoload.php';

class ValidatorUtil{

    private $validator;


    public function addValidationArray($validationArray){
        $this->validator = new Validator($validationArray);
        Validator::addRule('regularExpression', function($field, $value, array $params, array $fields) {
         return (empty($field) || empty($value))?false: preg_match($params[0], $value);
        }, 'must contain valid characters');
        Validator::addRule('alphaNumeric', function($field, $value, array $params, array $fields) {
            return (empty($field) || empty($value))?false: preg_match('/^([a-z0-9])+$/i', $value);
        }, 'must contain alpha Numeric');
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
            $this->validator->rule('regularExpression',$field,$regularExpression);
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
        $this->validator->rule('alphaNumeric',$field);
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