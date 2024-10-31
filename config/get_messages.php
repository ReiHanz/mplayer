<?php
session_start();
include 'db.php'; // Koneksi ke database

// Pastikan pengguna telah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

// Ambil semua pesan dari tabel chat_messages
$stmt = $pdo->query("SELECT chat_messages.message, chat_messages.sent_at, users.username 
                     FROM chat_messages 
                     JOIN users ON chat_messages.user_id = users.id 
                     ORDER BY chat_messages.sent_at ASC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kembalikan pesan dalam format JSON
echo json_encode($messages);
?>
