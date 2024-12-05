<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Ambil semua data peminjaman
$sql = "SELECT p.id, a.nama AS nama_auditorium, p.tanggal, p.waktu_mulai, p.waktu_selesai, p.id_pengguna, p.status 
        FROM peminjaman p
        INNER JOIN auditorium a ON p.id_auditorium = a.id
        ORDER BY p.tanggal DESC, p.waktu_mulai DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard_admin.css">
    <title>Peminjaman Auditorium UPNVJ</title>
</head>
<body>
    <header class="custom-header d-flex justify-content-between align-items-center">
        <!-- Logo dan Tulisan Admin -->
        <div class="d-flex align-items-center">
            <img src="logo_upnvj.jpg" alt="Logo UPNVJ">
            <div>
                <h6 class="mb-0">ADMIN</h6>
                <small>UPN "Veteran" Jakarta</small>
            </div>
        </div>

        <!-- Judul Halaman di Tengah -->
        <h5 class="text-center flex-grow-1 mb-0" style="font-size: 16px; color: #333;">Auditorium UPNVJ</h5>

        <!-- Info Tambahan -->
        <div class="d-flex align-items-center">
            <span class="me-3"><?= date('d-m-Y'); ?></span>
            <i class="fas fa-bell"></i>
        </div>
    </header>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 custom-sidebar text-white d-flex flex-column min-vh-100 p-3">
                <div class="text-center mb-4">
                    <img src="profil.png" alt="Profile" class="img-fluid rounded-circle mb-2" width="100">
                    <h6>Samsuri</h6>
                    <small>ADMIN</small>
                </div>
                <ul class="nav flex-column mb-auto">
                    <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="daftar_admin.php" class="nav-link">Daftar Auditorium</a></li>
                    <li class="nav-item"><a href="riwayat_peminjaman.php" class="nav-link text-white">Riwayat Peminjaman</a></li>
                </ul>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto">Log out</a>
            </div>

            <!-- Main Content -->
            
    <footer>
        <div class="footer-text">
            <p>&copy; Universitas Pembangunan Nasional "Veteran" Jakarta 2024 | All Rights Reserved</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>