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

    protected function response($key,$object){
        $this->responseArray[$key]=$object;
    }

    protected function successResponse($message){
        $data = array();
        $data['message']=$message;
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    protected function responseBody($data){
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    protected function responseBodyOrNotFoundMessage($data){
        if(empty($data)){
            $this->errorResponse("Informacion no encontrada",Response::HTTP_NOT_FOUND);
        }
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    protected function errorResponse($messages,$httpStatusCode=Response::HTTP_HTTP_UNPROCESSABLE_ENTITY){
        $data = array();
        if(is_array($messages)){
            $data['messages']=$messages;
            $data['type']="VALIDATION";
        }else{
            $data['message']=$messages;
            $data['type']="GLOBAL";
        }
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code($httpStatusCode);
        exit();
    }

    protected function requestBody($convertToArray=true){
        $jsonBody=file_get_contents('php://input');
        return json_decode($jsonBody,$convertToArray);
    }

}