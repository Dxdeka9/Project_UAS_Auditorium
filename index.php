<?php
include 'includes/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cegah SQL Injection
    $email = $conn->real_escape_string($email);

    $sql = "SELECT * FROM pengguna WHERE email='$email'";
    $result = $conn->query($sql);

    $error = ""; // Variabel untuk pesan error

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if (isset($_POST['remember_me'])) {
                setcookie('username', $email, time() + (86400 * 30), "/"); // Cookie username disimpan selama 30 hari
                setcookie('password', base64_encode($password), time() + (86400 * 30), "/"); // Cookie password disimpan selama 30 hari
            }

            // Redirect ke dashboard sesuai role
            if ($user['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}

    $username_cookie = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
    $password_cookie = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="slideshow.css">
</head>
<body>
    <!-- Slideshow container -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="upnvj_bg-1.jpg" style="width:100%">
        </div>
        <div class="mySlides fade">
            <img src="DSC04787.JPG" style="width:100%">
        </div>
        <div class="mySlides fade">
            <img src="DSC00861.jpg" style="width:100%">
        </div>
    </div>
    <div class="container">
        <div class="login-container">
            <h1>Login</h1>

            <!-- Tampilkan notifikasi error jika ada -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($username_cookie); ?>">
                <input type="password" name="password" placeholder="Password" required value="<?php echo htmlspecialchars($password_cookie); ?>">
                <button type="submit">Login</button>
                
                <!-- Checkbox "Ingat Saya" dipindahkan ke bawah tombol Login -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="remember_me">Ingat saya</label>
                </div>
            </form>
            <a href="register.php">Create an Account</a>
        </div>
    </div>
    <script src="slideshow.js"></script>
</body>
</html>

