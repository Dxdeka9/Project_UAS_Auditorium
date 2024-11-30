<?php
include 'includes/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $email = $conn->real_escape_string($email);

    $sql = "SELECT * FROM pengguna WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p style='color: red;'>Password salah!</p>";
        }
    } else {
        echo "<p style='color: red;'>Email tidak terdaftar!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="slideshow.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Slideshow Background -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="assets/upnvj_bg-1.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="assets/DSC04787.JPG" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="assets/DSC00861.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Create an Account</a>
    </div>

    <script src="slideshow.js"></script>
</body>
</html>


