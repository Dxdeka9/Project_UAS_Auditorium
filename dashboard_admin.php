<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Query data yang hanya relevan untuk admin
$sql = "SELECT p.id, a.nama as nama_auditorium, p.tanggal, p.waktu_mulai, p.waktu_selesai, u.nama as nama_pengguna 
        FROM peminjaman p 
        INNER JOIN auditorium a ON p.id_auditorium = a.id
        INNER JOIN pengguna u ON p.id_pengguna = u.id
        ORDER BY p.tanggal DESC, p.waktu_mulai DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <h1>Dashboard Admin</h1>
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Auditorium</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Nama Pengguna</th>
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
                        <td><?php echo htmlspecialchars($row['nama_pengguna']); ?></td>
                    </tr>
                <?php 
                $i++;
                endwhile; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger">Log out</a>
    </div>
</body>
</html>
