<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register-style.css">
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <!-- Image with a size of 100x100 -->
            <img src="img/mp.jpg" alt="Logo" style="width: 100px; height: 80px; margin: 0 auto;">
            
            <h2>Create Your Account</h2>
            <form action="config/user.php" method="POST">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="register">Register</button>
                </div>
                <p class="login-link">Already have an account? <a href="index.php">Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>
