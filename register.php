<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']); // Mengambil data form 'nama_lengkap' dan membersihkannya menggunakan real_escape_string untuk mencegah SQL Injection
    $email = $conn->real_escape_string($_POST['email']); // Mengambil data dari form 'email' dan membersihkannya menggunakan metode real_escape_string untuk mencegah SQL Injection
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // enkripsi password
    $role = 'mahasiswa'; // Set role default sebagai 'user = mahasiswa'

    // Query untuk menyimpan data
    $sql = "INSERT INTO pengguna (nama_lengkap, email, password, role) 
            VALUES ('$nama_lengkap', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) { // eksekusi query dan memeriksa apakah berhasil
        $_SESSION['message'] = "Registrasi berhasil!"; // pesan sukses dalam sesi
        $_SESSION['message_type'] = "success"; 
    } else {
        $_SESSION['message'] = "Error: " . $conn->error; // pesan error dalam sesi
        $_SESSION['message_type'] = "danger"; 
    }
    header("Location: register.php"); // untuk mengarahkan ke register sebelum ke index
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- tampilan res[onsif -->
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styling/register.css"> <!-- untuk style register -->
    <link rel="stylesheet" href="styling/slideshow.css"> <!-- untuk style slideshow image -->
</head>
<body>
    <!-- Slideshow Background -->
    <div class="slideshow-container"> <!-- Container untuk slideshow -->
        <div class="mySlides active">
            <img src="asset\page1.jpg" alt="Page 1">
        </div>
        <div class="mySlides">
            <img src="asset\page2.jpg" alt="Page 2">
        </div>
        <div class="mySlides">
            <img src="asset\page3.jpg" alt="Page 3">
        </div>
    </div>

    <!-- Register Form -->
    <div class="register-container">
        <h1><b>Registrasi</b></h1>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (isset($_SESSION['message'])): ?> <!-- Memeriksa apakah ada pesan dalam sesi -->
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?> <!-- Menampilkan pesan dari sesi -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            //notif pesan
            $message_type = $_SESSION['message_type']; // Menyimpan tipe pesan ke variabel dan menghapus pesan dari sesi
            unset($_SESSION['message'], $_SESSION['message_type']); // Menghapus pesan dari sesi setelah ditampilkan
            ?>
            <!-- Redirect ke index.php setelah 3 detik jika registrasi berhasil -->
            <?php if ($message_type == "success"): ?> <!-- Jika tipe pesan adalah "success" -->
                <script>
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 3000); // Waktu tunggu 3 detik sebelum redirect
                </script>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- form register -->
        <form method="POST">
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label> <!-- Label untuk input nama lengkap -->
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap Anda" required> <!-- Input nama lengkap -->
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label> <!-- Label untuk input email -->
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" required> <!-- Input email -->
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label> <!-- Label untuk input password -->
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required> <!-- Input password -->
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button> <!-- Tombol submit -->
            </form>
        </form>
        <a href="index.php">Sudah punya akun? Login di sini</a> <!-- Link untuk login -->
    </div>

    <script src="slideshow.js"></script> <!-- script bagian slideshow -->
</body>
</html>
