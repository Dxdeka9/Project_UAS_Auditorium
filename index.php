<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna berdasarkan email
    $sql = "SELECT * FROM pengguna WHERE email='$email'";
    $result = $conn->query($sql);

    $error = ""; // Variabel untuk pesan error

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set sesi pengguna
            $_SESSION['user_id'] = $user['id_user']; // Pastikan sesuai dengan kolom di tabel
            $_SESSION['role'] = $user['role'];

            // Jika remember me dicentang, simpan cookie
            if (isset($_POST['remember_me'])) {
                setcookie('email', $email, time() + (86400 * 30), "/"); // Cookie email selama 30 hari
                setcookie('password', base64_encode($password), time() + (86400 * 30), "/"); // Cookie password selama 30 hari
            }

            // Redirect berdasarkan role
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

// Ambil data dari cookie jika tersedia
$email_cookie = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$password_cookie = isset($_COOKIE['password']) ? base64_decode($_COOKIE['password']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styling/index.css">
    <link rel="stylesheet" href="styling/slideshow.css">
</head>
<body>
    <!-- Slideshow container -->
    <div class="slideshow-container">
        <div class="mySlides active">
            <img src="asset/page1.jpg" alt="Page 1">
        </div>
        <div class="mySlides">
            <img src="asset/page2.jpg" alt="Page 2">
        </div>
        <div class="mySlides">
            <img src="asset/page3.jpg" alt="Page 3">
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
                <input type="text" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email_cookie); ?>">
                <input type="password" name="password" placeholder="Password" required value="<?php echo htmlspecialchars($password_cookie); ?>">
                <button type="submit">Login</button>
                
                <!-- Checkbox "Ingat Saya" dipindahkan ke bawah tombol Login -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="remember_me">Ingat saya</label>
                </div>
            </form>
            <a href="register.php">Create an Account</a>
        </div>
    </div>
    <script src="js/slideshow.js"></script>
</body>
</html>