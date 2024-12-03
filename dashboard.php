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
    <title>Dashboard Mahasiswa FIK UPNVJ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            height: 100vh;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        .btn {
            display: block;
            width: 100%;
        }
        .table-container {
            padding: 2rem;
        }
        .alert {
            text-align: center;
        }
    </style>
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
        <div class="col-9">
            <div class="table-container">
                <h3>Riwayat Peminjaman</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Auditorium</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_auditorium']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['waktu_mulai'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['waktu_selesai'])); ?></td>
                                </tr>
                            <?php 
                        $i++;
                        endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($result->num_rows == 0): ?>
                    <div class="alert alert-info">
                        Belum ada riwayat peminjaman.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<!-- 
<script src="cookie.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () =>{
            const userEmail = getCookie('user_email');
            const userPassword = getCookie('user_Password');
            if (userEmail && userPassword){
                document.getElementById('userGreeting').innerText = `Selamat Datang ${userEmail}! ID kamu adalah ${userPassword}.`;
            } else {
                alert('User tidak login!. Kembali ke halaman login.');
                window.location.href = 'index.php';
            }
        });
    </script>
-->