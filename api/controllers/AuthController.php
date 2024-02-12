<?php

require_once "api/models/AuthModel.php";
require_once "api/core/Middleware.php";

class AuthController {
    private $model;

    function __construct() {
        $this->model = new AuthModel();    
    }

    // Fungsi terdiri dari <method>_<enpoint>
    public function post_login() {
        $post = Input::inputPost();

        $user = $this->model->getUserByEmail($post['email']);
        if (!$user) {
            $data = [
                "success" => false,
                "message" => "Data user tidak ditemukan"
            ];
            return Response::JSON($data, 404);
        }

        if (!password_verify($post['password'], $user['password'])) {
            $data = [
                "success" => false,
                "message" => "Password Salah!"
            ];
            return Response::JSON($data, 403);
        }

        $claims = [
            "userId" => $user['id'],
            "email" => $user['email']
        ];
        $token = JWTHelper::generateToken($claims);
        $refreshToken = JWTHelper::generateToken($claims, 43200);

        $data = [
            "success" => true,
            "message" => "Login Berhasil",
            "data" => [
                "access_token" => $token,
                "refresh_token" => $refreshToken
            ]
        ];
        return Response::JSON($data);
    }

    public function get_refresh() {
        $userdata = Middleware::checkJWT();

        $claims = [
            "userId" => $userdata['id'],
            "email" => $userdata['email']
        ];
        $token = JWTHelper::generateToken($claims);
        $refreshToken = JWTHelper::generateToken($claims, 43200);

        $data = [
            "success" => true,
            "message" => "Refresh Token Berhasil",
            "data" => [
                "access_token" => $token,
                "refresh_token" => $refreshToken
            ]
        ];
        return Response::JSON($data);
    }
}