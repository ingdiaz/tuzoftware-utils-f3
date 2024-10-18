<?php

namespace Core\Base;

class ResponseMessage {


    public function successResponse() {
        http_response_code(Response::HTTP_OK); // OK
        exit();
    }

    public function responseBody($data) {
        header('Content-type: application/json');
        echo json_encode($data); // Solo los datos
        http_response_code(Response::HTTP_OK); // OK
        exit();
    }


    public function responseDataTableBodyOrNotFoundMessage($data, $totalRecords) {
        if (empty($data)) {
            $this->errorResponse("Información no encontrada", Response::HTTP_NOT_FOUND);
        }
        $jsonData = array($data, $totalRecords); // Solo los valores (data y totalRecords)
        header('Content-type: application/json');
        echo json_encode($jsonData);
        http_response_code(Response::HTTP_OK); // OK
        exit();
    }

    public function responseBodyOrNotFoundMessage($data) {
        if (empty($data)) {
            $this->errorResponse("Información no encontrada", Response::HTTP_NOT_FOUND);
        }
        $jsonData = array($data); // Solo los valores (data y totalRecords)
        header('Content-type: application/json');
        echo json_encode($jsonData);
        http_response_code(Response::HTTP_OK); // OK
        exit();
    }


    public function errorResponse($message, $httpStatusCode = Response::HTTP_HTTP_UNPROCESSABLE_ENTITY) {
        $data = array(
            'messages' => $message
        );
        header('Content-type: application/json');
        echo json_encode($data);
        http_response_code($httpStatusCode); // Código de error 422 por defecto
        exit();
    }

}

