<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

// Upload Music
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $file = $_FILES['music_file']['name'];
    $target_dir = "../uploads/" . basename($file);
    
    if (move_uploaded_file($_FILES['music_file']['tmp_name'], "$target_dir")) {
        $stmt = $pdo->prepare("INSERT INTO music (title, file_path, uploaded_by) VALUES (?, ?, ?)");
        $stmt->execute([$title, $target_dir, $_SESSION['user_id']]);
        header("Location: dashboard.php");
    }
}

// Add to Favorites
if (isset($_POST['favorite'])) {
    $music_id = $_POST['music_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO favorites (user_id, music_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $music_id]);
    header("Location: ../index.php");
}

// Get Favorites
function getFavorites($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM favorites INNER JOIN music ON favorites.music_id = music.id WHERE favorites.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Delete Music (Admin)
if (isset($_POST['delete']) && $_SESSION['role'] == 'admin') {
    $music_id = $_POST['music_id'];
    $stmt = $pdo->prepare("DELETE FROM music WHERE id = ?");
    $stmt->execute([$music_id]);
    header("Location: ../index.php");
}

?>
