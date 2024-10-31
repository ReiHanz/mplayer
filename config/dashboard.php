<?php
session_start();
include 'db.php';
include 'music.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$music_list = $pdo->query("SELECT * FROM music")->fetchAll();
$favorites = getFavorites($pdo, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Music Player</title>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Welcome, <?php echo $_SESSION['role']; ?></h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section: Upload Music and Favorites -->
        <div class="left-section">
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <h2>Upload Music</h2>
                <form action="music.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Music Title" required>
                    <input type="file" name="music_file" accept="audio/*" required>
                    <button type="submit" name="upload">Upload</button>
                </form>
            <?php endif; ?>

            <h2>Your Favorites</h2>
            <?php foreach ($favorites as $fav): ?>
                <div class="music-item">
                    <h4><?php echo $fav['title']; ?></h4>
                    <audio controls>
                        <source src="<?php echo $fav['file_path']; ?>" type="audio/mpeg">
                    </audio>
                </div>
            <?php endforeach; ?>

            <div class="live-chat">
                <h2>Live Chat</h2>
                
                <div id="chat-box">
                    <div id="chat-messages"></div> <!-- Pesan chat akan ditampilkan di sini -->
                </div>

                <form id="chat-form">
                    <input type="text" id="chat-input" placeholder="Type your message here..." required>
                    <button type="submit">Send</button>
                </form>
            </div>

        
        </div>

        <!-- Right Section: Music List -->
        <div class="right-section">
            <h2>Music List</h2>
            <?php foreach ($music_list as $music): ?>
                <div class="music-item">
                    <h4><?php echo $music['title']; ?></h4>
                    <audio controls class="audio-player">
                        <source src="<?php echo $music['file_path']; ?>" type="audio/mpeg">
                    </audio>
                    <form action="music.php" method="POST">
                        <input type="hidden" name="music_id" value="<?php echo $music['id']; ?>">
                        <button type="submit" name="favorite">Favorites</button>
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <button type="submit" name="delete">Delete</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Script to allow only one audio to play at a time -->
    <script src="../js/script.js"></script>
</body>
</html>
