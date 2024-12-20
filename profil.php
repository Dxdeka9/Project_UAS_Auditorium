<?php
include 'includes/db.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect ke index.php
    exit(); // Hentikan eksekusi kode lebih lanjut
}

// Mengambil ID pengguna yang sedang login dari session
$user_id = $_SESSION['user_id'];

// Query untuk mengambil informasi pengguna dari database berdasarkan ID
$sql = "SELECT * FROM pengguna WHERE id_user = ?";
$stmt = $conn->prepare($sql); // Mempersiapkan statement untuk mencegah SQL Injection
$stmt->bind_param("i", $user_id); // Mengikat parameter ID pengguna
$stmt->execute(); // Menjalankan query
$result = $stmt->get_result(); // Mengambil hasil query

// Mengecek apakah data pengguna ditemukan di database
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Menyimpan data pengguna dalam array asosiatif
} else {
    $error = "Data pengguna tidak ditemukan."; // Pesan error jika data tidak ditemukan
    $user = null; // Mengatur data pengguna ke null
}

// Mengatur zona waktu menjadi Asia/Bangkok
date_default_timezone_set("Asia/Bangkok");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5d9c59;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="asset/putih.png" alt="Logo MahasiswaUPNVJ" style="width: 190px; height: auto;">
            </div>
            <div class="d-flex align-items-center text-light">
            <span class="me-3" style="font-size: 16px;">Date : <?= date('d-m-Y'); ?></span>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-4 d-flex flex-column">
            <div class="text-center mb-4">
                <?php
                     if (isset($user['foto_profile']) && !empty($user['foto_profile'])) {
                        echo "<img src='" . $user['foto_profile'] . "' class='object-fit-cover profile-picture rounded-circle mb-3'style='width: 100px; height: 100px;' />";
                     } else {
                        echo "<img src='asset/profil.png' class='profile-picture rounded-circle mb-3'style='width: 100px; height: 100px;' />";
                     }
                  ?>
                <h5><?php echo htmlspecialchars($user['nama_lengkap']); ?></h5>
            </div>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-light">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_ruang.php" class="nav-link text-light">Daftar Auditorium</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="profil.php" class="nav-link text-active">Profil</a>
                </li>
            </ul>
            <a href="peminjaman.php" class="btn btn-success w-100 mt-3">Ajukan Peminjaman</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="main-content col-md-10 p-4">
            <h2 class="mb-4">Profil Mahasiswa</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php else: ?>
                
                <table class="table table-bordered bg-white rounded shadow-sm">
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?php echo htmlspecialchars($user['nama_lengkap']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td><?php echo htmlspecialchars($user['no_telp']); ?></td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td><?php echo htmlspecialchars($user['program_studi']); ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Induk Mahasiswa</th>
                        <td><?php echo htmlspecialchars($user['nim']); ?></td>
                    </tr>
                </table>
                <a href="edit_profil.php" class="btn btn-primary mt-3">Edit Profil</a>
            <?php endif; ?>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- Footer -->
    <footer class="bg-white text-secondary py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
