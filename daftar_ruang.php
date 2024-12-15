<?php
    include 'includes/db.php'; // menghubungkan ke database lewat file db.php
    session_start(); // memulai session

    // Cek apakah user sudah login
    if (!isset($_SESSION['user_id'])) { // jika user belum login berdasarkan data dari session
        header("Location: index.php"); // maka arahkan ke index.php
        exit();
    }

    // Ambil informasi pengguna dari database untuk ambil nama dan profile
    $user_id = $_SESSION['user_id']; // ambil id pengguna dari session
    $sql = "SELECT * FROM pengguna WHERE id_user = ?"; // query untuk mengambil data pengguna yg ID-nya sesuai $user_id
    $stmt = $conn->prepare($sql); // siapkan pernyataan SQL
    $stmt->bind_param("i", $user_id); // untuk mengisi placeholder ? di query dengan nilai dari $user_id. i itu integer
    $stmt->execute(); // query dijalankan di database.
    $result = $stmt->get_result(); // Data hasil pencarian disimpan ke dalam variabel $result

    if ($result->num_rows > 0) { // jika hasil query ada baris data
        $user = $result->fetch_assoc(); // hasilnya diubah jadi array (fetch_assoc()) dan disimpan di var user
    } else {
        $error = "Data pengguna tidak ditemukan."; // Jika data tidak ditemukan, vari $user akan diisi null
        $user = null;
    }

    // Tangkap filter yang dipilih (jika ada)
    $filter_lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : ''; //apakah parameter lokasi ada di URL. Jika ada, disimpan di variabel $filter_lokasi

    // Query untuk mendapatkan daftar auditorium berdasarkan filter lokasi
    $query_auditorium = "SELECT id_auditorium, nama_auditorium, lokasi_kampus FROM auditorium"; // mengambil data id, nama, dan lokasi auditorium dari database
    if ($filter_lokasi != '') { // jika filter lokasi tidak kosong
        $query_auditorium .= " WHERE lokasi_kampus = '$filter_lokasi'"; // tambahkan kondisi WHERE untuk memfilter lokasi
    }
    $result_auditorium = $conn->query($query_auditorium); // jalankan query di database

    date_default_timezone_set("Asia/Bangkok");; // mengatur zona waktu menjadi Asia/Bangkok
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
                <span class="me-3" style="font-size: 16px;">Date : <?= date('d-m-Y'); ?></span>
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
            <div class="col-md-10 p-4" id="ruang">
                <h4>Ruang Auditorium</h4>
                <br>
                <!-- Tabs -->
                <div class="nav nav-pills mb-3" role="group" aria-label="Filter Buttons">
                    <a href="daftar_ruang.php" class="nav-item nav-link active me-2 <?= $filter_lokasi == '' ? 'active' : '' ?>">Semua</a>
                    <a href="pondok_labu.php?lokasi=Kampus Pondok Labu" class="btn btn-secondary me-2 <?= $filter_lokasi == 'Kampus Pondok Labu' ? 'active' : '' ?>">Kampus Pondok Labu</a>
                    <a href="limo.php?lokasi=Kampus Limo" class="btn btn-secondary <?= $filter_lokasi == 'Kampus Limo' ? 'active' : '' ?>">Kampus Limo</a>
                </div>
                
                <!-- Room List -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="asset/BTI_depan.jpg" alt="Card image cap">
                            <div class="card-body mb-3">
                                <h5 class="card-title text-center">Auditorium Bhineka Tunggal Ika</h5>
                                <p class="card-text text-center">Kampus Pondok Labu</p>
                                <div class="d-flex justify-content-center">
                                    <a href="selengkapnya_BTI.php" class="btn btn-primary">Selengkapnya &raquo;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="asset/FK.jpg" alt="Card image cap">
                            <div class="card-body mb-3">
                                <h5 class="card-title text-center">Auditorium Dr. Wahidin Sudiro Husodo</h5>
                                <p class="card-text text-center">Kampus Pondok Labu</p>
                                <div class="d-flex justify-content-center">
                                    <a href="selengkapnya_FK.php" class="btn btn-primary">Selengkapnya &raquo;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="asset/Merce.jpg" alt="Card image cap">
                            <div class="card-body mb-3">
                                <h5 class="card-title text-center">Auditorium MERCE Kedokteran</h5>
                                <p class="card-text text-center">Kampus Limo</p>
                                <div class="d-flex justify-content-center">
                                    <a href="selengkapnya_MERCE.php" class="btn btn-primary">Selengkapnya &raquo;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card" style="width: 18rem; height: 23rem;">
                            <img class="card-img-top" src="asset/Tanah_Airku.jpg" alt="Card image cap">
                            <div class="card-body mb-3">
                                <h5 class="card-title text-center">Auditorium <br>Tanah Airku</h5>
                                <p class="card-text text-center">Kampus Limo</p>
                                <div class="d-flex justify-content-center">
                                    <a href="selengkapnya_FT.php" class="btn btn-primary">Selengkapnya &raquo;</a>
                                </div>
                            </div>
                        </div>
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