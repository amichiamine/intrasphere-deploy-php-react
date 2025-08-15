<?php
class Response {
    public static function success($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(['status'=>'success', 'data'=>$data]);
        exit;
    }

    public static function error($message, $status = 500) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(['status'=>'error', 'message'=>$message]);
        exit;
    }
}