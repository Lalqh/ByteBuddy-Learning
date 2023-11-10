<?php

class Responses {

    public function __construct() {
    }

    public function sendResponse($message, $data = "") {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'message' => $message,
            'data' => $data,
        ]);
        exit();
    } 
}

?>
