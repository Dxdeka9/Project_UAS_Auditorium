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
                <img src="profil.png" alt="Profile Picture" class="profile-picture rounded-circle mb-3" style="width: 100px; height: 100px;">
                <h5>Mahasiswa</h5>
            </div>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item mb-2">
                    <a href="profil.php" class="nav-link text-light">Profil</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-light">Riwayat Peminjaman</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="daftar_ruang.php" class="nav-link text-active">Daftar Ruang</a>
                </li>
            </ul>
            <a href="peminjaman.php" class="btn btn-success w-100 mt-3">Ajukan Peminjaman</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-2">Log Out</a>
        </div>
        <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="container py-4">
                    <h2>Auditorium Fakultas Teknik</h2>
                    <div style="width: 500px; margin: 0 auto;">
                        <img src="auditorium 1.jpg" alt="Auditorium FT" class="img-fluid rounded">
                    </div>
                    <div class="details text-left mb-4">
                        <p><strong><br>Lokasi:</strong> Gedung Rektorat, lantai 4</p>
                        <p><strong>Jam Operasional:</strong> 07.00 WIB - 16.00 WIB</p>
                    </div>
                    <div style="text-align:justify">
                        <p>
                            Auditorium Bhineka Tunggal Ika merupakan salah satu fasilitas utama yang dimiliki oleh Universitas Pembangunan Nasional (UPN) "Veteran" Jakarta. Sebagai ruang multifungsi, auditorium ini sering digunakan untuk berbagai kegiatan, seperti seminar, rapat besar, pelatihan, acara kemahasiswaan, hingga pertemuan formal tingkat universitas. Dengan kapasitas dan fasilitas modern, Auditorium Bhineka Tunggal Ika didesain untuk mendukung penyelenggaraan acara yang membutuhkan ruang luas dan representatif. Auditorium ini mencerminkan nilai-nilai kebhinekaan dan persatuan, sesuai dengan nama yang diusungnya, menjadikannya simbol penting bagi aktivitas akademik dan non-akademik di lingkungan kampus.
                        </p>
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
