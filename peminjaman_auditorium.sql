-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Nov 2024 pada 06.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_auditorium`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auditorium`
--

CREATE TABLE `auditorium` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auditorium`
--

INSERT INTO `auditorium` (`id`, `nama`, `lokasi`) VALUES
(1, 'Auditorium BTI', 'BTI'),
(2, 'Auditorium FK', 'Pondok Labu'),
(3, 'Auditorium MERCE Kedokteran', 'Limo'),
(4, 'Auditorium FISIP', 'FISIP'),
(5, 'Auditorium FT', 'Lantai 8');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_auditorium` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `status` enum('pending','approved','declined') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_pengguna`, `id_auditorium`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `keperluan`, `status`) VALUES
(4, 1, 1, '2025-12-12', '12:00:00', '15:00:00', 'android', 'pending'),
(5, 1, 3, '2024-12-01', '13:00:00', '15:00:00', 'apa aja', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('mahasiswa','admin') DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Abduh', 'abduhrevan40904@gmail.com', '$2y$10$GRbZcVTiwY7LpdZklyGVkuPDbVnX8DWbU8DnAA9Tlb11/Nv4TAXei', 'mahasiswa'),
(2, 'tes', 'tes@gmail.com', '$2y$10$tTtil/XFleJmtNV.wRJpOeAqHpXhug34yXRqMqSNvzuF2VGRCvRhy', 'mahasiswa'),
(3, 'Revan', 'abduhrevan40904@gmail.com', '$2y$10$1j7v2nytSQi6dO8vEEyU/O5BqBk8i8oPNSxvMoB4QsrVYPuGcK2/O', 'mahasiswa'),
(4, 'Sekar', 'sekar@gmail.com', '$2y$10$RBqkOyWqIF9FquGmoB9dteSQQ/sR2NHbVKZSm4VlXTD9z1F6fs8iO', 'mahasiswa'),
(5, 'Abduh', 'abduh@gmail.com', '$2y$10$IVa/.NJUdvgbuk1vuYMZOu69pY4UBWSv5S.CMnQyB90AiHJeJSZ8e', 'mahasiswa'),
(6, 'pandu', 'pandu@gmail.com', '$2y$10$1l2FNBS2aCMKDnUm8mZas.z3eRBRxYh9KUyDs7nEyeuww/cJew15a', 'mahasiswa'),
(7, 'tes', 'tes@gmail.com', '$2y$10$HSfQ5PE/TSCdA2mi9zDcv.bXgdqA8rn3LKCx.nuruMhTD.uaXpNe2', 'mahasiswa'),
(8, 'Abduh', 'abduhrevan40904@gmail.com', '$2y$10$DapePJvM.RwkugYbgpIYzOGDj2ry5YiYL2qOd7B4GsDqTsWwpyLxu', 'mahasiswa'),
(9, 'tes', 'tes@gmail.com', '$2y$10$A4yvVXN0cBgmatO89IJxc.KCHAM.fzuXHbKAHeYmxUvWO8fkvvQii', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auditorium`
--
ALTER TABLE `auditorium`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_auditorium` (`id_auditorium`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auditorium`
--
ALTER TABLE `auditorium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_auditorium`) REFERENCES `auditorium` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
