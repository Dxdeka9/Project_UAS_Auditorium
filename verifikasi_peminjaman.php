<?php
include 'includes/db.php';
session_start();

$id_peminjaman = $_GET['id'];
$action = $_GET['action'];

$query = "SELECT * FROM peminjaman WHERE id_peminjaman = $id_peminjaman";
$result = $conn->query($query);

if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      $id_user = $row['id_user'];
      $id_auditorium = $row['id_auditorium'];
      $peminjam = $row['peminjam'];
      $tanggal_pinjam = $row['tanggal_pinjam'];
      $waktu_mulai = $row['waktu_mulai'];
      $waktu_selesai = $row['waktu_selesai'];
      $foto_surat = $row['foto_surat'];
      $status = $row['status'];

      // Update status peminjaman menjadi 'approved'
      $query2 = "UPDATE peminjaman SET status = '$action' WHERE id_peminjaman = $id_peminjaman";
      $result2 = $conn->query($query2);

      if ($result) {
         echo "Berhasil memperbarui status peminjaman";

         $query3 = "INSERT INTO riwayat_peminjaman (id_peminjaman, id_user, id_auditorium, peminjam, tanggal_pinjam, waktu_mulai, waktu_selesai, foto_surat, status) VALUES ($id_peminjaman, $id_user, $id_auditorium, '$peminjam', '$tanggal_pinjam', '$waktu_mulai', '$waktu_selesai', '$foto_surat', '$action')";
         $result3 = $conn->query($query3);

         if ($result3) {
            echo "Berhasil insert ke riwayat_peminjaman";

            $query4 = "DELETE FROM peminjaman WHERE id_peminjaman = $id_peminjaman";
            $result4 = $conn->query($query4);

            echo "Berhasil menghapus data peminjaman";

            header("Location: dashboard_admin.php");
         } else {
            echo "Error inserting into riwayat_peminjaman: " . $conn->error;
         }
      } else {
         echo "Error updating peminjaman: " . $conn->error;
      }

} else {
   echo "Data peminjaman tidak ditemukan";
}