<?php
// Menambahkan header CORS untuk memungkinkan permintaan dari domain lain
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: POST"); // Mengizinkan metode POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Mengizinkan header tertentu

require_once "../includes/database.php"; // File koneksi database
header("Content-Type: application/json");

// Cek apakah data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari input
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    // Validasi input
    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Username and password are required."]);
        exit();
    }

    // Koneksi ke database
    $database = new Database();
    $conn = $database->getConnection();

    // Cek apakah username sudah ada
    $query = "SELECT id FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Username already exists."]);
        exit();
    }

    // Enkripsi password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert data pengguna baru ke database
    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User registered successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "User registration failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
