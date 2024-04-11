<?php

namespace Core\Base;

class ResponseMessage{

    private $responseArray;

    public function __construct(){
        $this->responseArray=array();
    }

    public function response($key,$object){
        $this->responseArray[$key]=$object;
    }

    public function successResponse($message){
        $data = array();
        $data['message']=$message;
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    public function responseBody($data){
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    public function responseBodyOrNotFoundMessage($data){
        if(empty($data)){
            $this->errorResponse("Informacion no encontrada",Response::HTTP_NOT_FOUND);
        }
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    public function errorResponse($messages,$httpStatusCode=Response::HTTP_HTTP_UNPROCESSABLE_ENTITY){
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

}