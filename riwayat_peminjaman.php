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
    $query_user = "SELECT nama_lengkap FROM pengguna WHERE id_user = $user_id";
    $result_user = $conn->query($query_user);

    $nama_admin = $result_user->num_rows > 0 ? htmlspecialchars($result_user->fetch_assoc()['nama_lengkap']) : "Admin Tidak Ditemukan";

    // Ambil search term jika ada
    $search_data = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    $sql = "SELECT r.id_riwayat, a.nama_auditorium, r.peminjam, r.tanggal_pinjam, r.waktu_mulai, r.waktu_selesai, r.foto_surat, r.status 
            FROM riwayat_peminjaman r
            INNER JOIN auditorium a ON r.id_auditorium = a.id_auditorium
            WHERE r.id_user = ? AND a.nama_auditorium LIKE ?
            ORDER BY r.tanggal_pinjam DESC, r.waktu_mulai DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    date_default_timezone_set("Asia/Bangkok");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="daftar&riwayat.css">
        <title>Riwayat Peminjaman - Auditorium UPNVJ</title>
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
    <!-- End Navbar -->

    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-4 d-flex flex-column">
            <div class="text-center mb-4">
                <img src="asset/profil.png" alt="Profile" class="img-fluid rounded-circle mb-3" width="100">
                <h4 class="mb-0 text-light"><?php echo $nama_admin; ?></h4>
                <small>ADMIN</small>
            </div>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item mb-2">
                    <a href="dashboard_admin.php" class="nav-link text-light">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_admin.php" class="nav-link text-light">Daftar Auditorium</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="riwayat_peminjaman.php" class="nav-link text-active">Riwayat Peminjaman</a>
                </li>
            </ul>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>

                <div class="col-md-10 p-4">
                    <div class="col-md-10 mb-3">
                        <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan nama, tanggal, atau peminjam" value="<?= htmlspecialchars($search_data); ?>">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                <th>No.</th>
                                <th>Auditorium</th>
                                <th>Peminjam</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="search-results">
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
                                            <td><?php echo $row['id_user']; ?></td>
                                            <!-- pandu di bawah ini buat fitur delete kalo mau -->
                    <!-- fitur delete --> <td><?php echo "<a href='?delete_id=$id_audit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus auditorium ini?\");'>Delete</a>" ?></td> -->
                                            <td>
                                                <?= ucfirst($row['status']); ?>
                                            </td>
                                        </tr>
                                    <?php 
                                    $i++;
                                endwhile; ?>
                            </tbody>
                        </table>
                        <?php if ($result->num_rows == 0): ?>
                            <div class="alert alert-info mt-3">Belum ada data peminjaman.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
  <footer class="bg-white text-secondary py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="riwayat_peminjaman.js"></script>
    </body>
</html>