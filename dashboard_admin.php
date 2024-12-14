<?php
    include 'includes/db.php';
    session_start();

    // Cek apakah user sudah login dan memiliki peran admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }

    // Ambil nama pengguna dari database berdasarkan user_id
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
    $query_user = "SELECT nama_lengkap FROM pengguna WHERE id_user = $user_id"; // query untuk mengambil nama pengguna dari tabel pengguna
    $result_user = $conn->query($query_user); // untuk menjalankan query

    // Periksa apakah data pengguna ditemukan
    if ($result_user->num_rows > 0) { // jika data pengguna ditemukan
        $row_user = $result_user->fetch_assoc(); // ambil data pengguna dari hasil query
        $nama_admin = htmlspecialchars($row_user['nama_lengkap']); // Nama admin yang sedang login
    } else {
        $nama_admin = "Admin Tidak Ditemukan";
    }

    // Ambil semua data peminjaman
    $sql = "SELECT p.id_peminjaman, p.id_user, a.nama_auditorium, p.peminjam, p.tanggal_pinjam, p.waktu_mulai, p.waktu_selesai, p.foto_surat, p.status
            FROM peminjaman p
            INNER JOIN auditorium a ON p.id_auditorium = a.id_auditorium
            ORDER BY p.tanggal_pinjam DESC, p.waktu_mulai DESC";
    $result = $conn->query($sql);

    date_default_timezone_set("Asia/Bangkok");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .main-content {
                max-width: 100%;
                overflow-x: auto;
            }
        </style>
    </head>
    
    <body class="d-flex flex-column min-vh-100" style="background-color: #5d9c59;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #FDF7F4;">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="asset/logo_admin.png" alt="Logo Admin UPNVJ" style="width: 190px; height: auto;">
                </div>
                <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;"><b>Dashboard</b></h5>
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
                        <a href="dashboard_admin.php" class="nav-link text-active">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="daftar_admin.php" class="nav-link text-light">Daftar Auditorium</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="riwayat_peminjaman.php" class="nav-link text-light">Riwayat Peminjaman</a>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
            </div>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="main-content flex-grow-1 p-4">
                <h3 class="mb-4 text-light">Data Peminjaman Auditorium</h3>
                <div class="table-responsive shadow-sm p-3 mb-5 bg-light" style ="border-radius: 10px;">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead class="table-dark" style="text-align:center;">
                            <tr>
                                <th>No.</th>
                                <th>Auditorium</th>
                                <th>Peminjam</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                        <?php if (!empty($row['foto_surat'])): ?>
                                            <!-- Tampilkan tautan file -->
                                            <a href="<?php echo htmlspecialchars($row['foto_surat']); ?>" target="_blank">
                                                <?php if (strpos($row['foto_surat'], '.pdf') !== false): ?> <!-- strpos() untuk memeriksa apakah nama file mengandung .pdf Jika ya, tampilkan tombol "Lihat Surat".-->
                                                    <!-- Jika file adalah PDF -->
                                                    <button class="btn btn-primary">Surat</button>
                                                <?php else: ?>
                                                    <!-- Jika file adalah gambar -->
                                                    <img src="<?php echo htmlspecialchars($row['foto_surat']); ?>" alt="Surat" style="width: 120px; height: auto;">
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            Tidak Ada Surat
                                        <?php endif; ?>
                                    <td>
                                        <?php 
                                        if ($row['status'] == 'pending') {
                                            echo '<span class="badge bg-warning text-dark">Pending</span>';
                                        } elseif ($row['status'] == 'approved') {
                                            echo '<span class="badge bg-success">Approved</span>';
                                        } elseif ($row['status'] == 'rejected') {
                                            echo '<span class="badge bg-danger">Rejected</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="approve_peminjaman.php?id=<?php echo $row['id_peminjaman']; ?>" class="btn btn-success">Approve</a>
                                        <a href="reject_peminjaman.php?id=<?php echo $row['id_peminjaman']; ?>" class="btn btn-danger">Reject</a>
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

        <!-- Footer -->
        <footer class="bg-white text-secondary py-3 mt-auto">
            <div class="container text-center">
                <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>