-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Des 2024 pada 10.23
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_auditorium`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auditorium`
--

CREATE TABLE `auditorium` (
  `id_auditorium` int(255) NOT NULL,
  `nama_auditorium` varchar(255) NOT NULL,
  `lokasi_kampus` enum('Kampus Pondok Labu','Kampus Limo') NOT NULL,
  `lokasi_gedung` varchar(255) NOT NULL,
  `kapasitas` varchar(255) NOT NULL,
  `operasional` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_auditorium` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auditorium`
--

INSERT INTO `auditorium` (`id_auditorium`, `nama_auditorium`, `lokasi_kampus`, `lokasi_gedung`, `kapasitas`, `operasional`, `deskripsi`, `foto_auditorium`) VALUES
(1, 'Auditorium Bhineka Tunggal Ika', 'Kampus Pondok Labu', 'Lantai 4, Gedung Rektorat, UPN Kampus Pondok Labu', '400 Orang', 'Senin-Jumat pukul 07.00-16.00', '\r\nAuditorium Bhineka Tunggal Ika merupakan salah satu fasilitas utama yang dimiliki oleh Universitas Pembangunan Nasional (UPN) \"Veteran\" Jakarta. Sebagai ruang multifungsi, auditorium ini sering digunakan untuk berbagai kegiatan, seperti seminar, rapat besar, pelatihan, acara kemahasiswaan, hingga pertemuan formal tingkat universitas. Dengan kapasitas dan fasilitas modern, Auditorium Bhineka Tunggal Ika didesain untuk mendukung penyelenggaraan acara yang membutuhkan ruang luas dan representatif. Auditorium ini mencerminkan nilai-nilai kebhinekaan dan persatuan, sesuai dengan nama yang diusungnya, menjadikannya simbol penting bagi aktivitas akademik dan non-akademik di lingkungan kampus.', ''),
(2, 'Auditorium Dr. Wahidin Sudiro Husodo', 'Kampus Pondok Labu', 'Lantai 3, Gedung Dr.Wahidin S.H., UPN Kampus Pondok Labu', '200 Orang', 'Senin-Jumat pukul 07.00 WIB - 16.00 WIB', 'Auditorium Dr. Wahidin Sudiro Husodo merupakan salah satu fasilitas utama di Fakultas Kedokteran Universitas Pembangunan Nasional (UPN) \"Veteran\" Jakarta, Kampus Pondok Labu. Dirancang sebagai ruang multifungsi, auditorium ini sering digunakan untuk berbagai kegiatan, seperti seminar, pelatihan, rapat resmi, hingga acara kemahasiswaan. Dengan kapasitas 160 orang dan fasilitas modern, auditorium ini menyediakan lingkungan yang ideal untuk penyelenggaraan acara yang membutuhkan ruang yang luas, representatif, dan nyaman. Auditorium ini mencerminkan nilai profesionalisme dan semangat pendidikan, menjadikannya tempat yang tepat untuk berbagai kegiatan kampus.', ''),
(3, 'Auditorium MERCE Kedokteran', 'Kampus Limo', 'Lantai 4, Gedung Fakultas Kedokteran, UPN Kampus Limo', '160 Orang', 'Senin-Jumat pukul 07.00 WIB - 16.00 WIB', 'Auditorium Merce adalah salah satu fasilitas unggulan di Fakultas Kedokteran Universitas Pembangunan Nasional (UPN) \"Veteran\" Jakarta, Kampus Limo. Auditorium ini dirancang untuk mendukung berbagai kegiatan, seperti rapat formal, pelatihan, seminar, dan acara mahasiswa. Dengan kapasitas 160 orang dan fasilitas modern, auditorium ini menjadi tempat yang cocok untuk kegiatan yang membutuhkan suasana profesional dan nyaman. Auditorium Merce mencerminkan semangat kolaborasi dan inovasi di lingkungan kampus, sehingga menjadi lokasi yang cocok untuk kegiatan akademik maupun non-akademik.', ''),
(4, 'Auditorium Tanah Airku', 'Kampus Limo', 'Lantai 8, Gedung Fakultas Teknik, UPN Kampus Limo', '400 Orang', 'Senin-Jumat pukul 07.00 WIB - 16.00 WIB', 'Auditorium Tanah Airku merupakan fasilitas unggulan Fakultas Teknik Universitas Pembangunan Nasional (UPN) \"Veteran\" Jakarta, Kampus Limo. Dengan kapasitas besar yang mampu menampung hingga 400 orang, auditorium ini dirancang untuk mendukung berbagai acara berskala besar, seperti seminar nasional, konferensi, pelatihan, hingga acara kebudayaan. Fasilitas modern yang tersedia menjadikannya tempat yang strategis untuk berbagai kegiatan yang membutuhkan ruang yang luas dan representatif. Auditorium Tanah Airku mencerminkan semangat kebangsaan dan inovasi, menjadikannya tempat yang pas untuk mendukung berbagai kegiatan di lingkungan kampus.', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `id_auditorium` int(255) NOT NULL,
  `peminjam` varchar(255) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `foto_surat` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `program_studi` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `foto_profile` varchar(255) NOT NULL,
  `role` enum('mahasiswa','admin') DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `nama_lengkap`, `email`, `password`, `nim`, `program_studi`, `no_telp`, `foto_profile`, `role`) VALUES
(5, 'Abduh Revan', 'abduh@gmail.com', '$2y$10$a0G5dB5FNFMnrSRgE3j72.AkEBYA20JQPYL8pbrd3FaXwAeHVvHrW', '2310512160', 'S1-Sistem Informasi', '081234567891', 'uploads/6757f4939c8d3_baymax.jpeg', 'mahasiswa'),
(6, 'Samsuri', 'admin@gmail.com', '$2y$10$qchdliHZdvpm7xX.tvib4.Z1xWRjccKmKlP35fqjjVWn3KqOqyzXm', '2310512161', 'S1-Sistem Informasi', '081234567893', 'default.jpg', 'admin'),
(7, 'Sekar Purbaningrum', 'sekar@gmail.com', '$2y$10$yCBfOa8glO3tP7OYFdtRyuwCzFx0OznrXIXXqbulca05LHEuNc8qG', '', '', '', '', 'mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_peminjaman`
--

CREATE TABLE `riwayat_peminjaman` (
  `id_riwayat` int(255) NOT NULL,
  `id_peminjaman` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `id_auditorium` int(255) NOT NULL,
  `peminjam` varchar(255) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `foto_surat` varchar(255) NOT NULL,
  `status` enum('approved','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auditorium`
--
ALTER TABLE `auditorium`
  ADD PRIMARY KEY (`id_auditorium`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `idUser_fk` (`id_user`) USING BTREE,
  ADD KEY `idAuditorium_fk` (`id_auditorium`) USING BTREE;

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indeks untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `idpeminjaman_fk` (`id_peminjaman`),
  ADD KEY `iduser` (`id_user`),
  ADD KEY `idauditorium` (`id_auditorium`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auditorium`
--
ALTER TABLE `auditorium`
  MODIFY `id_auditorium` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_user` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  MODIFY `id_riwayat` int(255) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `idauditorium_fk` FOREIGN KEY (`id_auditorium`) REFERENCES `auditorium` (`id_auditorium`),
  ADD CONSTRAINT `iduser_fk` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  ADD CONSTRAINT `idauditorium` FOREIGN KEY (`id_auditorium`) REFERENCES `auditorium` (`id_auditorium`),
  ADD CONSTRAINT `idpeminjaman_fk` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`),
  ADD CONSTRAINT `iduser` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
