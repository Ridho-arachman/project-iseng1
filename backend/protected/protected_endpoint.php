<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: POST"); // Mengizinkan metode POST
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once "../includes/jwt.php";
header("Content-Type: application/json");
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';
if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
    $decoded = JWT::decode($token);
    if ($decoded) {
        echo json_encode(["status" => "success", "data" => $decoded['data']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid token."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Authorization header missing."]);
}
