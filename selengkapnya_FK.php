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
                        <a href="profil.php" class="nav-link text-dark">Profil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="dashboard.php" class="nav-link active">Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="daftar_ruang.php" class="nav-link text-dark">Daftar Ruang Auditorium</a>
                    </li>
                </ul>
                <a href="peminjaman.php" class="btn btn-primary w-100 mt-auto mb-3">Ajukan Peminjaman</a>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto">Log out</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="container py-4">
                    <h2>Auditorium Fakultas Kedokteran</h2>
                    <div style="width: 500px; margin: 0 auto;">
                        <img src="auditorium 1.jpg" alt="Auditorium FK" class="img-fluid rounded">
                    </div>
                    <div class="details text-left mb-2">
                        <p><strong><br>Lokasi:</strong> Gedung Wahidin Sudiro Husodo, lantai 3</p>
                        <p><strong>Kapasitas:</strong> 200 Orang</p>
                        <p><strong>Jam Operasional:</strong> 07.00 WIB - 16.00 WIB</p>
                    </div>
                    <div style="text-align:justify">
                        <p>
                            Auditorium ini dirancang untuk mendukung berbagai kegiatan akademik maupun non-akademik dengan kapasitas maksimal mencapai 200 orang. Lokasinya yang strategis di dalam lingkungan fakultas menjadikannya tempat yang ideal untuk seminar, lokakarya, diskusi panel, dan acara resmi lainnya. Dengan fasilitas yang memadai, auditorium ini berfungsi sebagai pusat kegiatan yang mendukung pengembangan pendidikan dan kegiatan kemahasiswaan di Fakultas Kedokteran.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
