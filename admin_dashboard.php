<?php
    include 'db.php';
    session_start();
    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: index.php");
    //     exit();
    // }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT p.id, a.nama as nama_auditorium, p.tanggal, p.waktu_mulai, p.waktu_selesai 
            FROM peminjaman p 
            INNER JOIN auditorium a ON p.id_auditorium = a.id 
            WHERE p.id_pengguna = ?
            ORDER BY p.tanggal DESC, p.waktu_mulai DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 custom-sidebar text-white d-flex flex-column min-vh-100 p-3">
                <div class="text-center mb-4">
                    <img src="logo_upnvj.jpg" alt="Logo UPNVJ" class="img-fluid rounded-circle mb-2" width="80">
                    <h5>ADMIN</h5>
                    <small>UPN "Veteran" Jakarta</small>
                </div>
                <hr>
                <div class="text-center mb-4">
                    <img src="profil.png" alt="Profile" class="img-fluid rounded-circle mb-2" width="100">
                    <h6>Samsuri</h6>
                    <small>ADMIN</small>
                </div>
                <ul class="nav flex-column mb-auto">
                    <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Daftar Auditorium</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Riwayat Peminjaman</a></li>
                </ul>
                <button class="btn btn-danger mt-auto">Logout</button>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <header class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-primary">Sistem Informasi Peminjaman Auditorium</h3>
                    <div>
                        <span class="me-3">Today: <?= date('d-m-Y'); ?></span>
                        <i class="fas fa-bell fs-4"></i>
                    </div>
                </header>
                
                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Auditorium</th>
                                <th>Tanggal</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['nama_auditorium']); ?></td>
                                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                                        <td><?= htmlspecialchars($row['waktu_mulai']); ?></td>
                                        <td><?= htmlspecialchars($row['waktu_selesai']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data peminjaman.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center py-3 bg-warning mt-4">
        <p>&copy; Universitas Pembangunan Nasional "Veteran" Jakarta 2024 | All Rights Reserved</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>