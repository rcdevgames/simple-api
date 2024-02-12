<?php

class Response {
    public static function JSON($data, $code=200) {
        header('Content-type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}