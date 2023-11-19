<?php

/**
 * Summary of Response
 */
class Response
{
    private $message;
    private $code;
    private $data;

    /**
     * Summary of __construct
     */
    public function __construct($code, $message, $data = "")
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * Summary of send
     * @param mixed $message
     * @param mixed $code
     * @param mixed $data
     * @return never
     */
    public function send()
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        echo json_encode([
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ]);
        exit();
    }
}

?>