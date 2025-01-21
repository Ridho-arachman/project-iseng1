<?php
// Menambahkan header CORS untuk memungkinkan permintaan dari domain lain
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: POST"); // Mengizinkan metode POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Mengizinkan header tertentu

require_once "../includes/database.php"; // File koneksi database

header("Content-Type: application/json");

// Function to update username and password
function updateUser($id, $newUsername, $newPassword)
{
    // Create a database object
    $database = new Database();
    $db = $database->getConnection();

    // Hash the password first
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Prepare the SQL query to update username and password
    $query = "UPDATE users SET username = :username, password = :password WHERE id = :id";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Now we pass the variable
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and check if the update was successful
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Get the incoming request data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required parameters are present
if (isset($data['id']) && isset($data['username']) && isset($data['password'])) {
    $id = $data['id'];
    $newUsername = trim($data['username']);
    $newPassword = $data['password'];

    // Validate the username and password
    if (empty($newUsername) || empty($newPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Username and password cannot be empty."
        ]);
        exit();
    }

    // Call the update function
    if (updateUser($id, $newUsername, $newPassword)) {
        // Success response
        echo json_encode([
            "status" => "success",
            "message" => "User updated successfully."
        ]);
    } else {
        // Failure response
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update user."
        ]);
    }
} else {
    // Missing parameters response
    echo json_encode([
        "status" => "error",
        "message" => "Missing required parameters."
    ]);
}
