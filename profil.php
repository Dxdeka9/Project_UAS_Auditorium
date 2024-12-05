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
    <title>Peminjaman Auditorium UPN "Veteran" Jakarta</title>
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
                    <h5>Mahasiswa</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link active">Profil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="dashboard.php" class="nav-link text-dark">Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="daftar_ruang.php" class="nav-link text-dark">Daftar Ruang Auditorium</a>
                    </li>
                </ul>
                <a href="peminjaman.php" class="btn btn-primary w-100 mb-3">Ajukan Peminjaman</a>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto">Log out</a>
            </div>
            <!-- Main Content -->
             <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Profil</title>
              <link rel="stylesheet" href="profil.css">
            </head>
            <body>
              <div class="profile-container">
                <h1>Profil</h1>
                <p>Universitas Pembangunan Nasional "Veteran" Jakarta</p>
                <hr>
                <div class="profile-content">
                  <div class="profile-photo">
                    <div class="photo-placeholder"></div>
                    <button class="save-btn">Simpan Perubahan</button><br>
                    <button class="reset-btn">Reset Perubahan</button>
                  </div>
                  <div class="profile-form">
                    <form>
                      <label for="fullname">Nama Lengkap</label>
                      <input type="text" id="fullname" name="fullname">
                      
                      <label for="email">Email</label>
                      <input type="email" id="email" name="email">
                      
                      <label for="nim">NIM</label>
                      <input type="text" id="nim" name="nim">
                      
                      <label for="study-program">Program Studi</label>
                      <input type="text" id="study-program" name="study-program">
                      
                      <label for="phone">Nomor Handphone</label>
                      <input type="text" id="phone" name="phone">
                    </form>
                  </div>
                </div>
              </div>
            </body>
            </html>

            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
