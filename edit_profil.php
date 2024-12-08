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

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $program_studi = $_POST['program_studi'];
    $nim = $_POST['nim'];

    // Logika untuk mengunggah foto
    if (isset($_FILES['foto_profile']) && $_FILES['foto_profile']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $foto_name = basename($_FILES['foto_profile']['name']);
        $target_file = $target_dir . uniqid() . "_" . $foto_name;
        
        // Validasi file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['foto_profile']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $error = "Format foto tidak valid. Gunakan JPEG, PNG, atau GIF.";
        } elseif (move_uploaded_file($_FILES['foto_profile']['tmp_name'], $target_file)) {
            $foto_profile = $target_file;
        } else {
            $error = "Gagal mengunggah foto.";
        }
    }

    // Query pembaruan
    $update_sql = "UPDATE pengguna SET nama_lengkap = ?, email = ?, no_telp = ?, program_studi = ?, nim = ?" .
                  (isset($foto_profile) ? ", foto_profile = ?" : "") . " WHERE id_user = ?";
    $update_stmt = $conn->prepare($update_sql);
    if (isset($foto_profile)) {
        $update_stmt->bind_param("ssssssi", $nama_lengkap, $email, $no_telp, $program_studi, $nim, $foto_profile, $user_id);
    } else {
        $update_stmt->bind_param("sssssi", $nama_lengkap, $email, $no_telp, $program_studi, $nim, $user_id);
    }

    if ($update_stmt->execute()) {
        $success = "Profil berhasil diperbarui.";
        // Refresh data pengguna
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $error = "Terjadi kesalahan saat memperbarui profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5d9c59;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="logo_mahasiswa.png" alt="Logo MahasiswaUPNVJ" style="width: 190px; height: auto;">
            </div>
            <form class="d-flex ms-auto" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-4 d-flex flex-column">
            <div class="text-center mb-4">
                <?php
                     if (isset($user['foto_profile']) && !empty($user['foto_profile'])) {
                        echo "<img src='" . $user['foto_profile'] . "' class='profile-picture rounded-circle mb-3'style='width: 100px; height: 100px;' />";
                     } else {
                        echo "<img src='profil.png' class='profile-picture rounded-circle mb-3'style='width: 100px; height: 100px;' />";
                     }
                  ?>
                <h5><?php echo htmlspecialchars($user['nama_lengkap']); ?></h5>
            </div>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item mb-2">
                    <a href="profil.php" class="nav-link text-active">Profil</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-light">Riwayat Peminjaman</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_ruang.php" class="nav-link text-light">Daftar Ruang</a>
                </li>
            </ul>
            <a href="peminjaman.php" class="btn btn-success w-100 mt-3">Ajukan Peminjaman</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="main-content col-md-9 p-4">
            <h2 class="mb-4">Edit Profil</h2>

            <!-- Notifikasi -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- Form Edit Profil -->
            <form method="POST" class="bg-white p-4 rounded shadow-sm" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="foto_profile" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile">
                </div>
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($user['no_telp']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" id="program_studi" name="program_studi" value="<?php echo htmlspecialchars($user['program_studi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Nomor Induk Mahasiswa</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo htmlspecialchars($user['nim']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- Footer -->
    <footer class="bg-white text-secondary py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
