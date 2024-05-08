<?php

namespace Core\Base;

use Valitron\Validator;
Validator::langDir(__DIR__.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang');
Validator::lang('es');

require 'vendor/autoload.php';

class ValidatorUtil{

    private $validator;


    public function addValidationArray($validationArray){
        $this->validator = new Validator($validationArray);
        $this->validator->setPrependLabels(false);
        Validator::addRule('regularExpression', function($field, $value, array $params, array $fields) {
         return (empty($field) || empty($value))?false: preg_match($params[0], $value);
        }, 'contiene caracteres invalidos');
        Validator::addRule('alphaNumeric', function($field, $value, array $params, array $fields) {
            return (empty($field) || empty($value))?false: preg_match('/^([a-z0-9])+$/i', $value);
        }, 'debe contener solo letras a-z o números 0-9');
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
            $responseMessage=new ResponseMessage();
            $responseMessage->errorResponse($this->validator->errors(),ResponseType::FORM);
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
        $this->validator->rule('alphaNumeric',$field);
    }
    public function validateEmail($field, $required, $minLong, $maxLong)
    {
        $this->validateRequired($field, $required);
        $this->validator->rule('lengthBetween', $field, $minLong, $maxLong);
        $this->validator->rule('email', $field);
    }
    public function validateExistYesNoOptions($field){
        $options=array('SI','NO');
        $this->validator->rule('in',$field,$options);
    }
    public function validateExistAnyOption($field,$options){
        $this->validator->rule('in',$field,$options);
    }

}