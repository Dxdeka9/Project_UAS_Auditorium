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
        <link rel="stylesheet" href="dashboard_admin.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
        <title>Peminjaman Auditorium UPNVJ</title>
    </head>
    
    <body>
        <header class="custom-header d-flex justify-content-between align-items-center">
            <!-- Logo dan Tulisan Admin -->
            <div class="d-flex align-items-center">
                <img src="logo_admin.png" alt="Logo Admin UPNVJ" style="width: 190px; height: auto;">
            </div>

            <!-- Judul Halaman di Tengah -->
            <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;"><b>Peminjaman Auditorium UPNVJ</b></h5>

            <!-- Info Tambahan -->
            <div class="d-flex align-items-center">
                <span class="me-3" style="font-size: 16px;">Date : <?= date('d-m-Y'); ?></span>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="custom-sidebar col-md-2 text-white d-flex flex-column min-vh-100 p-3">
                    <div class="text-center mb-4 mt-4">
                        <img src="profil.png" alt="Profile" class="img-fluid rounded-circle mb-3" width="100">
                        <h4 class="mb-0 text-black"><?php echo $nama_admin; ?></h4>
                        <small>ADMIN</small>
                    </div>
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-black"><b>Dashboard</b></a></li>
                        <li class="nav-item"><a href="daftar_admin.php" class="nav-link text-white">Daftar Auditorium</a></li>
                        <li class="nav-item"><a href="riwayat_peminjaman.php" class="nav-link text-white mb-4">Riwayat Peminjaman</a></li>
                        <a href="logout.php" class="btn btn-danger w-100 mt-auto mb-2">Log out</a>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="col-md-12 p-4">
                    <div class="main-content table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <h3>Data Peminjaman Auditorium</h3>
                            <thead class="table-dark">
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
                                                <a href="uploads/<?php echo htmlspecialchars($row['foto_surat']); ?>" target="_blank">
                                                    <img src="uploads/<?php echo htmlspecialchars($row['foto_surat']); ?>" alt="Surat" style="width: 100px; height: auto;">
                                                </a>
                                            <?php else: ?>
                                                Tidak Ada Surat
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 'pending') {
                                                echo 'Pending';
                                            } elseif ($row['status'] == 'approved') {
                                                echo 'Approved';
                                            } elseif ($row['status'] == 'rejected') {
                                                echo 'Rejected';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="approve_peminjaman.php?id=<?php echo $row['id_user']; ?>" class="btn btn-success">Approve</a>
                                            <a href="reject_peminjaman.php?id=<?php echo $row['id_user']; ?>" class="btn btn-danger">Reject</a>
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
        <footer class="bg-white rounded text-secondary col-md-10 p-4">
            <div class="container text-center">
                <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>