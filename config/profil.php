<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Get the current user's information
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    
    // Handle file upload
    $profile_picture = $user['profile_picture']; // Keep old picture by default
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Create a unique file name and upload path
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './img/profile/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_picture = $newFileName;
            }
        }
    }

    // Update the user information in the database
    $updateQuery = $pdo->prepare("UPDATE users SET username = :username, email = :email, phone = :phone, address = :address, birthdate = :birthdate, profile_picture = :profile_picture, password = :password WHERE id = :id");
    $updateQuery->execute([
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'birthdate' => $birthdate,
        'profile_picture' => $profile_picture,
        'password' => $password,
        'id' => $user_id
    ]);

    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>User Profile</title>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1>User Profile</h1>
        <nav>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- Main Content -->
    <div class="main-container">
        <div class="profile-container">
            <!-- Display success message if profile updated -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Profile Display -->
            <div class="profile-display">
                <h2>Your Profile</h2>
                <p><img src="../img/profile/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="width:100px; height:100px;"></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($user['birthdate']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            </div>
            <hr>
            <!-- Profile Update Form -->
            <form action="profile.php" method="POST" class="profile-form" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="password">Password (leave blank to keep current):</label>
                    <input type="password" name="password" id="password" placeholder="New password">
                </div>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>
    </div>
    
</body>
</html>
