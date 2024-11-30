<?php
include 'includes/db.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables for error/success messages
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id_auditorium = isset($_POST['id_auditorium']) ? (int)$_POST['id_auditorium'] : 0;
        $tanggal = $_POST['tanggal'] ?? '';
        $waktu_mulai = $_POST['jam_mulai'] ?? '';
        $waktu_selesai = $_POST['jam_selesai'] ?? '';
        $keperluan = $_POST['keperluan'] ?? '';
        $id_pengguna = (int)$_SESSION['user_id'];

        if ($id_auditorium <= 0) throw new Exception("Pilih auditorium yang valid!");
        if ($tanggal < date('Y-m-d')) throw new Exception("Tanggal tidak boleh kurang dari hari ini!");
        if ($waktu_mulai >= $waktu_selesai) throw new Exception("Waktu selesai harus lebih besar dari waktu mulai!");

        // Check time conflicts
        $check_sql = "SELECT * FROM peminjaman 
                     WHERE id_auditorium = ? AND tanggal = ? 
                     AND status != 'declined' AND (
                        (waktu_mulai BETWEEN ? AND ?) 
                        OR (waktu_selesai BETWEEN ? AND ?)
                        OR (waktu_mulai <= ? AND waktu_selesai >= ?)
                     )";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("isssssss", 
            $id_auditorium, 
            $tanggal, 
            $waktu_mulai, 
            $waktu_selesai,
            $waktu_mulai, 
            $waktu_selesai,
            $waktu_mulai,
            $waktu_selesai
        );
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Jadwal yang dipilih sudah dibooking!");
        }
        $stmt->close();

        // Insert booking
        $sql = "INSERT INTO peminjaman (id_pengguna, id_auditorium, tanggal, waktu_mulai, waktu_selesai, keperluan, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissss", 
            $id_pengguna, 
            $id_auditorium, 
            $tanggal, 
            $waktu_mulai, 
            $waktu_selesai,
            $keperluan
        );
        if (!$stmt->execute()) {
            throw new Exception("Error saat menyimpan peminjaman!");
        }

        $message = "Peminjaman berhasil diajukan!";
        $stmt->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get list of auditoriums
$auditoriums = [];
try {
    $result = $conn->query("SELECT * FROM auditorium ORDER BY nama");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $auditoriums[] = $row;
        }
    }
} catch (Exception $e) {
    $error = "Error saat mengambil data auditorium: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Auditorium</title>
    <link rel="stylesheet" href="peminjaman.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <h2>Ajukan Peminjaman Auditorium</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="id_auditorium">Pilih Auditorium</label>
                    <select name="id_auditorium" id="id_auditorium" class="form-control" required>
                        <option value="">-- Pilih Auditorium --</option>
                        <?php foreach ($auditoriums as $auditorium): ?>
                            <option value="<?= $auditorium['id']; ?>">
                                <?= htmlspecialchars($auditorium['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan</label>
                    <textarea name="keperluan" id="keperluan" class="form-control" rows="4" required></textarea>
                </div>

                <div class="flex">
                    <button type="submit" class="btn-primary">Ajukan</button>
                    <a href="dashboard.php" class="btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

