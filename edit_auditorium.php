<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Ambil nama admin dari tabel pengguna
$user_id = $_SESSION['user_id'];
$query_user = "SELECT nama_lengkap FROM pengguna WHERE id_user = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$nama_admin = $result_user->num_rows > 0 ? htmlspecialchars($result_user->fetch_assoc()['nama_lengkap']) : "Admin Tidak Ditemukan";
$stmt_user->close();

// Tangkap ID auditorium yang akan diedit
if (isset($_GET['id'])) {
    $id_auditorium = $_GET['id'];

    // Query untuk mengambil data auditorium berdasarkan ID
    $query_auditorium = "SELECT nama_auditorium, lokasi_kampus, lokasi_gedung, kapasitas, operasional, deskripsi 
                         FROM auditorium WHERE id_auditorium = ?";
    $stmt = $conn->prepare($query_auditorium);
    $stmt->bind_param("i", $id_auditorium);
    $stmt->execute();
    $result_auditorium = $stmt->get_result();

    if ($result_auditorium->num_rows > 0) {
        $auditorium = $result_auditorium->fetch_assoc();
        $nama_auditorium = htmlspecialchars($auditorium['nama_auditorium']);
        $lokasi_kampus = htmlspecialchars($auditorium['lokasi_kampus']);
        $lokasi_gedung = htmlspecialchars($auditorium['lokasi_gedung']);
        $kapasitas = htmlspecialchars($auditorium['kapasitas']);
        $operasional = htmlspecialchars($auditorium['operasional']);
        $deskripsi = htmlspecialchars($auditorium['deskripsi']);
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
    $lokasi_kampus_update = $_POST['lokasi_kampus'];
    $lokasi_gedung_update = $_POST['lokasi_gedung'];
    $kapasitas_update = $_POST['kapasitas'];
    $operasional_update = $_POST['operasional'];
    $deskripsi_update = $_POST['deskripsi'];

    // Query untuk update data auditorium
    $query_update = "UPDATE auditorium 
                     SET nama_auditorium = ?, lokasi_kampus = ?, lokasi_gedung = ?, kapasitas = ?, operasional = ?, deskripsi = ? 
                     WHERE id_auditorium = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ssssssi", $nama_update, $lokasi_kampus_update, $lokasi_gedung_update, $kapasitas_update, $operasional_update, $deskripsi_update, $id_auditorium);

    if ($stmt_update->execute()) {
        // Redirect setelah berhasil update
        header("Location: daftar_admin.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengupdate data.');</script>";
    }

    $stmt_update->close();
    date_default_timezone_set("Asia/Bangkok");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auditorium - UPNVJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #5d9c59;">
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #FDF7F4;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="asset/logo_admin.png" alt="Logo Admin UPNVJ" style="width: 190px; height: auto;">
            </div>
            <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;"><b>Peminjaman Auditorium UPNVJ</b></h5>
            <div class="d-flex align-items-center">
                <span class="me-3" style="font-size: 16px;">Date : <?= date('d-m-Y'); ?></span>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center mb-4">Edit Data Auditorium</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Auditorium</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama_auditorium ?>" required>
            </div>
            <div class="mb-3">
                <label for="lokasi_kampus" class="form-label">Lokasi Kampus</label>
                <input type="text" class="form-control" id="lokasi_kampus" name="lokasi_kampus" value="<?= $lokasi_kampus ?>" required>
            </div>
            <div class="mb-3">
                <label for="lokasi_gedung" class="form-label">Lokasi Gedung</label>
                <input type="text" class="form-control" id="lokasi_gedung" name="lokasi_gedung" value="<?= $lokasi_gedung ?>" required>
            </div>
            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?= $kapasitas ?>" required>
            </div>
            <div class="mb-3">
                <label for="operasional" class="form-label">Jam Operasional</label>
                <input type="text" class="form-control" id="operasional" name="operasional" value="<?= $operasional ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= $deskripsi ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update</button>
        </form>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
