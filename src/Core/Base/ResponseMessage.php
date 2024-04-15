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
        $data['responseType']=ResponseType::GLOBAL;
        $data['type']=ResponseMessageType::SUCCESS;
        $data['messages']=$message;
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
            $this->errorResponse("Informacion no encontrada",ResponseType::GLOBAL,ResponseMessageType::WARN,Response::HTTP_NOT_FOUND);
        }
        $data['responseType']=ResponseType::GLOBAL;
        $data['type']=ResponseMessageType::SUCCESS;
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code(Response::HTTP_OK);
        exit();
    }

    public function errorResponse($messages, $type=ResponseType::GLOBAL, $subType=ResponseMessageType::ERROR, $httpStatusCode=Response::HTTP_HTTP_UNPROCESSABLE_ENTITY){
        $data = array();
        $data['messages']=$messages;
        $data['responseType']=$type;
        $data['type']=$subType;
        echo json_encode($data);
        header('Content-type: application/json');
        http_response_code($httpStatusCode);
        exit();
    }

}