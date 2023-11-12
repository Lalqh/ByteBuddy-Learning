<?php

/**
 * Summary of Response
 */
class Response
{
    private $message;
    private $code;

    /**
     * Summary of __construct
     */
    public function __construct($message, $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Summary of send
     * @param mixed $message
     * @param mixed $code
     * @return never
     */
    public function send()
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'message' => $this->message,
            'data' => $this->code,
        ]);
        exit();
    }
}

?>