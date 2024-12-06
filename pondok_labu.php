<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                        <a href="profil.php" class="nav-link text-dark">Profil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="dashboard.php" class="nav-link text-dark">Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="daftar_ruang.php" class="nav-link">Daftar Ruang Auditorium</a>
                    </li>
                </ul>
                <a href="peminjaman.php" class="btn btn-primary w-100 mt-auto mb-3">Ajukan Peminjaman</a>
                <a href="logout.php" class="btn btn-danger w-100 mt-auto">Log out</a>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 p-4" id="ruang">
                <h4>Ruang Auditorium</h4>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <input type="text" class="form-control w-50" placeholder="Cari Ruangan...">
                    <button class="btn btn-light"><i class="bi bi-bell"></i></button>
                </div>
                <!-- Tabs -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item">
                        <a href="daftar_ruang.php" class="nav-link">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a href="pondok_labu.php" class="nav-link active">UPN Pondok Labu</a>
                    <li class="nav-item">
                        <a href="limo.php" class="nav-link">UPN Limo</a>
                </ul>
                <!-- Room List -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Bhineka Tunggal Ika</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_BTI.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Fakultas Kedokteran</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_FK.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Auditorium Fakultas Ilmu Sosial & Politik</h5>
                                <p class="text-muted">UPN Pondok Labu</p>
                                <a href="selengkapnya_FISIP.php">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
