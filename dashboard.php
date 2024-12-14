<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: index.php");
    exit();
}

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM pengguna WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $error = "Data pengguna tidak ditemukan.";
    $user = null;
}

// Jika ada request untuk menghapus data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $user_id = $_SESSION['user_id'];

    // Hapus data hanya jika milik pengguna yang login
    $stmt_delete = $conn->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ? AND id_user = ?");
    $stmt_delete->bind_param("ii", $delete_id, $user_id);

    if ($stmt_delete->execute()) {
        $success_message = "Data berhasil dihapus.";
    } else {
        $error_message = "Terjadi kesalahan saat menghapus data.";
    }
    $stmt_delete->close();
}

// Ambil data riwayat peminjaman untuk mahasiswa yang sedang login
$search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';
$sql = "SELECT p.id_peminjaman, p.id_user, a.nama_auditorium, p.peminjam, p.tanggal_pinjam, p.waktu_mulai, p.waktu_selesai, p.foto_surat, p.status
        FROM peminjaman p
        INNER JOIN auditorium a ON p.id_auditorium = a.id_auditorium
        WHERE a.nama_auditorium LIKE ? 
        OR p.peminjam LIKE ?
        OR p.tanggal_pinjam LIKE ?
        ORDER BY p.tanggal_pinjam DESC, p.waktu_mulai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();
date_default_timezone_set("Asia/Bangkok")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            max-width: 100%;
            overflow-x: auto;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location.href = 'dashboard.php?delete_id=' + id;
            }
        }
    </script>
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
                    <a href="dashboard.php" class="nav-link text-active">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_ruang.php" class="nav-link text-light">Daftar Auditorium</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="profil.php" class="nav-link text-light">Profil</a>
                </li>
            </ul>
            <a href="peminjaman.php" class="btn btn-success w-100 mt-3">Ajukan Peminjaman</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <h3 class="mb-4">Daftar Peminjaman Auditorium</h3>
            <div class="table-responsive shadow-sm p-3 mb-5">
                <form class="d-flex ms-auto mb-2" role="search">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Auditorium</th>
                            <th>Peminjam</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row['nama_auditorium']); ?></td>
                                <td><?php echo htmlspecialchars($row['peminjam']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                                <td><?php echo date('H:i', strtotime($row['waktu_mulai'])); ?></td>
                                <td><?php echo date('H:i', strtotime($row['waktu_selesai'])); ?></td>
                                <td>
                                    <?php
                                    $status = [
                                        'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
                                        'approved' => '<span class="badge bg-success">Approved</span>',
                                        'rejected' => '<span class="badge bg-danger">Rejected</span>',
                                    ];
                                    echo $status[$row['status']];
                                    ?>
                                </td>
                            </tr>
                            <?php 
                        $i++;
                        endwhile; ?>
                    </tbody>
                </table>
                <?php if ($result->num_rows == 0): ?>
                    <div class="alert alert-info mt-3">Tidak ada hasil pencarian untuk kata kunci tersebut.</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- Footer -->
    <footer class="bg-white text-secondary py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
