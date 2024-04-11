<?php

namespace Core\Base;
class Controller
{
    protected $f3;
    private $responseArray;
    protected $data;


    public function __construct(){
        $this->f3 = \Base::instance();
        $this->responseArray=array();
    }

    protected function urlParameters(){
        return $this->f3->get("GET");
    }

    protected function urlParameterName($parameterName){
       return $this->f3->get("PARAMS.".$parameterName);
    }

    protected function post($parameterName){
        return $this->f3->get("POST.".$parameterName);
    }


    protected function get($parameterName){
        return $this->f3->get("GET.".$parameterName);
    }

    protected function base(){
        return $this->f3->get('BASE');
    }

    protected function requestBody($convertToArray=true){
        $jsonBody=file_get_contents('php://input');
        return json_decode($jsonBody,$convertToArray);
    }

}