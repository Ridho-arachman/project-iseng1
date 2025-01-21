<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: POST"); // Mengizinkan metode POST
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once "../includes/jwt.php";
require_once "../includes/database.php";
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Username and password are required."]);
        exit;
    }
    $database = new Database();
    $conn = $database->getConnection();
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $payload = [
                "iss" => "your_domain.com",
                "aud" => "your_domain.com",
                "iat" => time(),
                "exp" => time() + (60 * 60), // Token berlaku selama 1 jam
                "data" => [
                    "id" => $user['id'],
                    "username" => $user['username']
                ]
            ];
            $jwt = JWT::encode($payload);
            echo json_encode(["status" => "success", "token" => $jwt]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
