<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query untuk menyimpan data
    $sql = "INSERT INTO pengguna (nama, email, password) VALUES ('$nama', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Registrasi berhasil!";
        $_SESSION['message_type'] = "success"; 
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['message_type'] = "danger"; 
    }
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="slideshow.css">
</head>
<body>
    <!-- Slideshow Background -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="page1.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="page2.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="page3.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
    </div>

    <!-- Register Form -->
    <div class="register-container">
        <h1><b>Registrasi</b></h1>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            //notif pesan
            $message_type = $_SESSION['message_type'];
            unset($_SESSION['message'], $_SESSION['message_type']);
            ?>
            <!-- Redirect ke index.php setelah 3 detik jika registrasi berhasil -->
            <?php if ($message_type == "success"): ?>
                <script>
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 3000);
                </script>
            <?php endif; ?>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <a href="index.php">Sudah punya akun? Login di sini</a>
    </div>

    <script src="slideshow.js"></script>
</body>
</html>
