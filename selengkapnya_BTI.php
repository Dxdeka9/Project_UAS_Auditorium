<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #5d9c59; ">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="asset/putih.png" alt="Logo MahasiswaUPNVJ" style="width: 190px; height: auto;">
            </div>
            <div class="d-flex align-items-center text-light">
                <span class="me-3" style="font-size: 16px;"><?= date('d-m-Y'); ?></span>
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
                    <a href="dashboard.php" class="nav-link text-light">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_ruang.php" class="nav-link text-active">Daftar Auditorium</a>
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
            <div class="col-md-9 shadow-sm">
                <div class="container py-4 t" style="text-align: left; padding: 2rem;">
                    <?php
            $sql = "SELECT * FROM auditorium WHERE nama_auditorium = 'Auditorium Bhineka Tunggal Ika'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data
                while($row = $result->fetch_assoc()) {
                    if ($row["nama_auditorium"] == "Auditorium Bhineka Tunggal Ika") {
                        echo "<h2>" . $row["nama_auditorium"] . "</h2>";
                        echo "<div style='width: 500px; margin: 0 auto;'>";
                        echo "<img src='" . $row["foto_auditorium"] . "' alt='Auditorium Bhineka Tunggal Ika' class='img-fluid rounded' style='position:left;'>";
                        echo "</div>";
                        echo "<div class='details text-left' style='padding:2rem;text-align:justify;'>";
                        echo "<p><strong>Lokasi:</strong> " . $row["lokasi_gedung"] . "</p>";
                        echo "<p><strong>Kapasitas:</strong> " . $row["kapasitas"] . " Orang</p>";
                        echo "<p><strong>Jam Operasional:</strong> " . $row["operasional"] . "</p>";
                        echo "<p>" . $row["deskripsi"] . "</p>";
                        echo "</div>";
                        echo "<div style='text-align:right;'>";
                        echo "<a href='daftar_ruang.php' class='btn btn-secondary mb-3'>Kembali</a>";
                        echo "</div>";
                    }
                }
            } else {
                echo "Tidak ada data.";
            }
            ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Footer -->
    <footer class="bg-white rounded text-secondary py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
