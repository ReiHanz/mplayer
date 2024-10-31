<?php
session_start();
include 'db.php'; // Koneksi ke database

// Pastikan pengguna telah login dan ada session user_id
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

// Ambil data dari request
$messageData = json_decode(file_get_contents('php://input'), true);

// Validasi bahwa data pesan ada dan tidak kosong
if (!isset($messageData['message']) || trim($messageData['message']) === '') {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Message is required"]);
    exit;
}

$message = trim($messageData['message']);
$user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

// Simpan pesan ke basis data
$stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, message, sent_at) VALUES (:user_id, :message, NOW())");
$stmt->execute(['user_id' => $user_id, 'message' => $message]);

// Kembalikan response berhasil
echo json_encode(["success" => true]);
?>
