<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO pengguna (nama, email, password) VALUES ('$nama', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Registrasi berhasil!');
            window.location => 'index.php';
            </script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
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
    <link rel="stylesheet" href="slideshow.css"> <!-- Tambahkan file CSS slideshow -->
</head>
<body>
    <!-- Slideshow Background -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="upnvj_bg-1.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="DSC04787.JPG" style="width:100%; height:100vh; object-fit:cover;">
        </div>
        <div class="mySlides fade">
            <img src="DSC00861.jpg" style="width:100%; height:100vh; object-fit:cover;">
        </div>
    </div>

    <!-- Register Form -->
    <div class="register-container">
        <h1><b>Registrasi</b></h1>
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

    <script src="slideshow.js"></script> <!-- Tambahkan file JavaScript slideshow -->
</body>
</html>

