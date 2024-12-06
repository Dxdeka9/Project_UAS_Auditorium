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
                <img src="profil.png" alt="Profile Picture" class="profile-picture rounded-circle mb-3" style="width: 100px; height: 100px;">
                <h5>Mahasiswa</h5>
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
        <div class="main-content flex-grow-1 p-4">
            <h3 class="mb-4">Profil Mahasiswa</h3>
            <div class="p-4 shadow-sm bg-white rounded">
                <form>
                    <div class="row mb-3">
                        <label for="fullname" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" id="fullname" name="fullname" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                        <div class="col-sm-9">
                            <input type="text" id="nim" name="nim" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="study-program" class="col-sm-3 col-form-label">Program Studi</label>
                        <div class="col-sm-9">
                            <input type="text" id="study-program" name="study-program" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-3 col-form-label">Nomor Handphone</label>
                        <div class="col-sm-9">
                            <input type="text" id="phone" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- Footer -->
    <footer class="bg-white rounded text-secondary py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Universitas Pembangunan Nasional "Veteran" Jakarta. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
