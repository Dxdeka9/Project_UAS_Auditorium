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

// Tangkap ID auditorium yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data auditorium berdasarkan ID
    $query_auditorium = "SELECT * FROM auditorium WHERE id = ?";
    $stmt = $conn->prepare($query_auditorium);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_auditorium = $stmt->get_result();

    if ($result_auditorium->num_rows > 0) {
        $auditorium = $result_auditorium->fetch_assoc();
        $nama = htmlspecialchars($auditorium['nama']);
        $lokasi = htmlspecialchars($auditorium['lokasi']);
    } else {
        echo "<script>alert('Auditorium tidak ditemukan.'); window.location.href='daftar_admin.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>alert('ID auditorium tidak ditemukan.'); window.location.href='daftar_admin.php';</script>";
    exit();
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_update = $_POST['nama'];
    $lokasi_update = $_POST['lokasi'];

    // Query untuk update data auditorium
    $query_update = "UPDATE auditorium SET nama = ?, lokasi = ? WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ssi", $nama_update, $lokasi_update, $id);

    if ($stmt_update->execute()) {
        // Redirect setelah berhasil update
        header("Location: daftar_admin.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengupdate data.');</script>";
    }

    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="daftar&riwayat.css">
    <title>Edit Auditorium - Auditorium UPNVJ</title>
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
    <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;">Edit Auditorium</h5>
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
                <!-- Form Edit Auditorium -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Auditorium</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= $lokasi ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
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
