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
$nama_admin = $result_user->num_rows > 0 ? htmlspecialchars($result_user->fetch_assoc()['nama_lengkap']) : "Admin Tidak Ditemukan"; // Ganti "nama" dengan "nama_lengkap"

// Tangkap filter yang dipilih (jika ada)
$filter_lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

// Proses delete jika ada ID yang diterima
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus auditorium berdasarkan ID
    $query_delete = "DELETE FROM auditorium WHERE id_auditorium = ?";
    
    // Persiapkan statement untuk menghindari SQL Injection
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param("i", $delete_id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect setelah berhasil menghapus
        header("Location: daftar_admin.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data.'); window.location.href='daftar_admin.php';</script>";
    }

    // Menutup statement
    $stmt->close();
}

// Query untuk mendapatkan daftar auditorium berdasarkan filter lokasi
$query_auditorium = "SELECT id_auditorium, nama_auditorium, lokasi_kampus FROM auditorium"; // Hapus koma tambahan
if ($filter_lokasi != '') {
    $query_auditorium .= " WHERE lokasi_kampus = '$filter_lokasi'"; // Pastikan kolom sesuai
}
$result_auditorium = $conn->query($query_auditorium);

date_default_timezone_set("Asia/Bangkok");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styling/daftar&riwayat.css">
    <title>Daftar Auditorium - Auditorium UPNVJ</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #5d9c59;">
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #FDF7F4;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="asset/logo_admin.png" alt="Logo Admin UPNVJ" style="width: 190px; height: auto;">
            </div>
            <h5 class="text-center flex-grow-1 mb-0" style="font-size: 20px;"><b>Daftar Auditorium</b></h5>
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
                    <a href="daftar_admin.php" class="nav-link text-active">Daftar Auditorium</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="riwayat_peminjaman.php" class="nav-link text-light">Riwayat Peminjaman</a>
                </li>
            </ul>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="container mt-4">
                <!-- Tombol Filter -->
                <div class="btn-group mb-3" role="group" aria-label="Filter Buttons">

                <!-- Tombol Semua -->
                <a href="daftar_admin.php" 
                class="btn <?= $filter_lokasi == '' ? 'btn-danger active' : 'btn-secondary' ?>">Semua</a>
       
                <!-- Tombol Kampus Pondok Labu -->
                <a href="daftar_admin.php?lokasi=Kampus Pondok Labu" 
                class="btn <?= $filter_lokasi == 'Kampus Pondok Labu' ? 'btn-danger active' : 'btn-secondary' ?>">Kampus Pondok Labu</a>
       
                <!-- Tombol Kampus Limo -->
                <a href="daftar_admin.php?lokasi=Kampus Limo" 
                class="btn <?= $filter_lokasi == 'Kampus Limo' ? 'btn-danger active' : 'btn-secondary' ?>">Kampus Limo</a>
            </div>


                <!-- Daftar Auditorium -->
                <div class="row">
                    <?php
                    if ($result_auditorium->num_rows > 0) {
                        while ($auditorium = $result_auditorium->fetch_assoc()) {
                            $id_audit = htmlspecialchars($auditorium['id_auditorium']);
                            $nama_auditorium = htmlspecialchars($auditorium['nama_auditorium']);
                            $lokasi_kampus = htmlspecialchars($auditorium['lokasi_kampus']);
                            echo "
                            <div class='col-md-4 mb-3'>
                                <div class='card shadow-sm'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$nama_auditorium</h5>
                                        <p class='card-text'>$lokasi_kampus</p>
                                        <div class='d-flex justify-content-between'>
                                            <a href='edit_auditorium.php?id=$id_audit' class='btn btn-primary'>Edit</a>
                                            <a href='?delete_id=$id_audit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus auditorium ini?\");'>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p class='text-center'>Tidak ada data auditorium.</p>";
                    }
                    ?>
                </div>
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
</body>
</html>
