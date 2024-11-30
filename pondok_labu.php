<?php
include 'includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light sidebar p-4">
                <div class="text-center mb-4">
                    <div class="profile-picture bg-secondary rounded-circle mb-3" style="width: 100px; height: 100px;"></div>
                    <h5>Contoh Nama</h5>
                    <p>Mahasiswa</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link text-dark">Profil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link active">Ruang Auditorium</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link text-dark">Daftar Peminjaman</a>
                    </li>
                </ul>
                <a href="peminjaman.php" class="btn btn-primary w-100 mt-auto mb-3">Ajukan Peminjaman</a>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto">Log out</a>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 p-4" id="ruang">
                <h4>Ruang Auditorium</h4>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <input type="text" class="form-control w-50" placeholder="Cari Ruangan...">
                    <button class="btn btn-light"><i class="bi bi-bell"></i></button>
                </div>
                <!-- Tabs -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a href="pondok_labu.php" class="nav-link active">UPN Pondok Labu</a>
                    <li class="nav-item">
                        <a href="limo.php" class="nav-link">UPN Limo</a>
                </ul>
                <!-- Room List -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Bhineka Tunggal Ika</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_BTI.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Fakultas Kedokteran</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_FK.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Fakultas Ilmu Sosial & Politik</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_FISIP.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
