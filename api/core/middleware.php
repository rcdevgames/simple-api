<?php 
require_once "api/models/AuthModel.php";

class Middleware {
    public static function checkJWT() {
        // Ambil token dari header Authorization
        $headers = apache_request_headers();
        $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

        // Periksa keberadaan token
        if (!$token) {
            $data = [
                "success" => false,
                "message" => "Akses tidak ditemukan"
            ];
            return Response::JSON($data, 401);
            exit();
        }

        // Periksa dan verifikasi token JWT
        $token = str_replace('Bearer ', '', $token);
        $jwt = JWTHelper::verifyToken($token);

        if (!$jwt) {
            $data = [
                "success" => false,
                "message" => "Akses tidak valid"
            ];
            return Response::JSON($data, 401);
            exit();
        }

        $model = new AuthModel();
        $userData = $model->getUserById($jwt->userId);

        if (!$userData) {
            $data = [
                "success" => false,
                "message" => "Akses tidak valid"
            ];
            return Response::JSON($data, 401);
            exit();
        }

        return $userData;
    }
}