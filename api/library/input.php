<?php 

use Ramsey\Uuid\Uuid;

class Input {
    public static function inputPost() {
        // Periksa apakah header Content-Type adalah application/json
        if (!array_key_exists('CONTENT_TYPE', $_SERVER) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $data = [
                "success" => false,
                "message" => "Tipe konten harus application/json"
            ];
            return Response::JSON($data, 400);
        }

        // Ambil data JSON dari body permintaan
        $jsonData = file_get_contents('php://input');

        // Coba untuk mem-parsing JSON
        $postData = json_decode($jsonData, true);

        // Periksa apakah JSON valid
        if ($postData === null) {
            $data = [
                "success" => false,
                "message" => "Data tidak valid. Pastikan format JSON benar."
            ];
            return Response::JSON($data, 400);
        }

        return filter_var_array($postData, FILTER_UNSAFE_RAW);
    }

    public static function generateUUID() {
        return Uuid::uuid4()->toString();
    }
}