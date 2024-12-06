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

// Ambil search term jika ada
$search_data = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Modifikasi query SQL untuk mencari berdasarkan nama auditorium, id_pengguna, atau tanggal
$sql = "SELECT p.id, a.nama AS nama_auditorium, p.tanggal, p.waktu_mulai, p.waktu_selesai, p.id_pengguna, p.status
        FROM peminjaman p
        INNER JOIN auditorium a ON p.id_auditorium = a.id
        WHERE a.nama LIKE '%$search_data%' 
        OR p.id_pengguna LIKE '%$search_data%' 
        OR p.tanggal LIKE '%$search_data%'
        ORDER BY p.tanggal DESC, p.waktu_mulai DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard_admin.css">
    <title>Riwayat Peminjaman - Auditorium UPNVJ</title>
</head>
<body>
<header class="custom-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="logo_upnvj.jpg" alt="Logo UPNVJ">
        <div>
            <h6 class="mb-0">ADMIN</h6>
            <small class="sub-text">UPN "Veteran" Jakarta</small>
        </div>
    </div>
    <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;">Riwayat Peminjaman Auditorium</h5>
    <div class="d-flex align-items-center">
        <span class="me-3"><?= date('d-m-Y'); ?></span>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <div class="custom-sidebar col-md-2 text-white d-flex flex-column min-vh-100 p-3">
            <div class="text-center mb-4">
                <img src="profil.png" alt="Profile" class="img-fluid rounded-circle mb-3" width="100">
                <h4 class="mb-0 text-black"><?php echo $nama_admin; ?></h4>
                <small>ADMIN</small>
            </div>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="daftar_admin.php" class="nav-link text-white">Daftar Auditorium</a></li>
                <li class="nav-item"><a href="riwayat_peminjaman.php" class="nav-link text-white mb-4">Riwayat Peminjaman</a></li>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto mb-2">Log out</a>
            </ul>
        </div>

        <div class="col-md-9 p-4">
            <div class="col-md-10 mb-3">
                <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan nama, tanggal, atau peminjam" value="<?= htmlspecialchars($search_data); ?>">
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Auditorium</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="search-results">
                        <?php 
                        $i = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= htmlspecialchars($row['nama_auditorium']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= date('H:i', strtotime($row['waktu_mulai'])); ?></td>
                                <td><?= date('H:i', strtotime($row['waktu_selesai'])); ?></td>
                                <td><?= htmlspecialchars($row['id_pengguna']); ?></td>
                                <td>
                                    <?= ucfirst($row['status']); ?>
                                </td>
                            </tr>
                        <?php 
                        $i++;
                        endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer-text">
        <p>&copy; Universitas Pembangunan Nasional "Veteran" Jakarta 2024 | All Rights Reserved</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="riwayat_peminjaman.js"></script>
</body>
</html>