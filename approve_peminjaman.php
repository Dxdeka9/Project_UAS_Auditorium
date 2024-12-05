<?php
include 'includes/db.php';
session_start();

// Cek apakah user sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$peminjaman_id = $_GET['id'];

// Update status peminjaman menjadi 'approved'
$sql = "UPDATE peminjaman SET status = 'approved' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $peminjaman_id);
if ($stmt->execute()) {
    // Redirect kembali ke halaman admin dashboard
    header("Location: dashboard_admin.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}