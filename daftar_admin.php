<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Ambil nama pengguna dari database berdasarkan user_id
$user_id = $_SESSION['user_id'];
$query_user = "SELECT nama FROM pengguna WHERE id = $user_id";
$result_user = $conn->query($query_user);
$nama_admin = $result_user->num_rows > 0 ? htmlspecialchars($result_user->fetch_assoc()['nama']) : "Admin Tidak Ditemukan";

// Tangkap filter yang dipilih (jika ada)
$filter_lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

// Proses delete jika ada ID yang diterima
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus auditorium berdasarkan ID
    $query_delete = "DELETE FROM auditorium WHERE id = ?";
    
    // Persiapkan statement untuk menghindari SQL Injection
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param("i", $delete_id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect setelah berhasil menghapus
        header("Location: daftar_admin.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data.'); window.location.href='daftar_admin.php';</script>";
    }

    // Menutup statement
    $stmt->close();
}

// Query untuk mendapatkan daftar auditorium berdasarkan filter lokasi
$query_auditorium = "SELECT id, nama, lokasi FROM auditorium";
if ($filter_lokasi != '') {
    $query_auditorium .= " WHERE lokasi = '$filter_lokasi'";
}
$result_auditorium = $conn->query($query_auditorium);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="daftar&riwayat.css">
    <title>Daftar Auditorium - Auditorium UPNVJ</title>
</head>
<body>
<header class="custom-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="logo_upnvj.jpg" alt="Logo UPNNVJ">
        <div>
            <h6 class="mb-0">ADMIN</h6>
            <small class="sub-text">UPN "Veteran" Jakarta</small>
        </div>
    </div>
    <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;">Daftar Auditorium</h5>
    <div class="d-flex align-items-center">
        <span class="me-3"><?= date('d-m-Y'); ?></span>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="custom-sidebar col-md-2 text-white d-flex flex-column min-vh-100 p-3">
            <div class="text-center mb-4">
                <img src="profil.png" alt="Profile" class="img-fluid rounded-circle mb-3" width="100">
                <h4 class="mb-0 text-black"><?= $nama_admin; ?></h4>
                <small>ADMIN</small>
            </div>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="daftar_admin.php" class="nav-link text-white">Daftar Auditorium</a></li>
                <li class="nav-item"><a href="riwayat_peminjaman.php" class="nav-link text-white mb-4">Riwayat Peminjaman</a></li>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto mb-2">Log out</a>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="container mt-4">
                <!-- Tombol Filter -->
                <div class="btn-group mb-3" role="group" aria-label="Filter Buttons">
                    <a href="daftar_admin.php" class="btn btn-danger <?= $filter_lokasi == '' ? 'active' : '' ?>">Semua</a>
                    <a href="daftar_admin.php?lokasi=UPNVJ Pondok Labu" class="btn btn-secondary <?= $filter_lokasi == 'UPNVJ Pondok Labu' ? 'active' : '' ?>">UPNVJ Pondok Labu</a>
                    <a href="daftar_admin.php?lokasi=UPNVJ Kampus Limo" class="btn btn-secondary <?= $filter_lokasi == 'UPNVJ Kampus Limo' ? 'active' : '' ?>">UPNVJ Kampus Limo</a>
                </div>

                <!-- Daftar Auditorium -->
                <div class="row">
                    <?php
                    if ($result_auditorium->num_rows > 0) {
                        while ($auditorium = $result_auditorium->fetch_assoc()) {
                            $id = htmlspecialchars($auditorium['id']);
                            $nama = htmlspecialchars($auditorium['nama']);
                            $lokasi = htmlspecialchars($auditorium['lokasi']);
                            echo "
                            <div class='col-md-4 mb-3'>
                                <div class='card shadow-sm'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$nama</h5>
                                        <p class='card-text'>$lokasi</p>
                                        <div class='d-flex justify-content-between'>
                                            <a href='edit_auditorium.php?id=$id' class='btn btn-primary'>Edit</a>
                                            <a href='?delete_id=$id' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus auditorium ini?\");'>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p class='text-center'>Tidak ada data auditorium.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer-text text-center">
        <p>&copy; Universitas Pembangunan Nasional "Veteran" Jakarta 2024 | All Rights Reserved</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
