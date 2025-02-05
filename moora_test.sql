-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Feb 2025 pada 03.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moora_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatives`
--

CREATE TABLE `alternatives` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alternatives`
--

INSERT INTO `alternatives` (`id`, `name`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'A3'),
(4, 'A4'),
(5, 'A5'),
(6, 'A6'),
(7, 'A7'),
(8, 'A8'),
(9, 'A9'),
(10, 'A10'),
(11, 'A11'),
(12, 'A12'),
(13, 'A13'),
(14, 'A14'),
(15, 'A15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternative_values`
--

CREATE TABLE `alternative_values` (
  `id` int(11) NOT NULL,
  `alternative_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `value` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alternative_values`
--

INSERT INTO `alternative_values` (`id`, `alternative_id`, `criterion_id`, `value`) VALUES
(13, 3, 1, 5.00),
(14, 3, 2, 5.00),
(15, 3, 3, 5.00),
(16, 3, 4, 5.00),
(17, 3, 5, 5.00),
(18, 3, 6, 5.00),
(19, 4, 1, 3.00),
(20, 4, 2, 4.00),
(21, 4, 3, 2.00),
(22, 4, 4, 3.00),
(23, 4, 5, 1.00),
(24, 4, 6, 3.00),
(25, 5, 1, 3.00),
(26, 5, 2, 5.00),
(27, 5, 3, 4.00),
(28, 5, 4, 4.00),
(29, 5, 5, 4.00),
(30, 5, 6, 3.00),
(31, 6, 1, 1.00),
(32, 6, 2, 4.00),
(33, 6, 3, 3.00),
(34, 6, 4, 4.00),
(35, 6, 5, 3.00),
(36, 6, 6, 5.00),
(37, 7, 1, 5.00),
(38, 7, 2, 5.00),
(39, 7, 3, 5.00),
(40, 7, 4, 5.00),
(41, 7, 5, 4.00),
(42, 7, 6, 2.00),
(43, 8, 1, 2.00),
(44, 8, 2, 4.00),
(45, 8, 3, 4.00),
(46, 8, 4, 3.00),
(47, 8, 5, 1.00),
(48, 8, 6, 4.00),
(49, 9, 1, 4.00),
(50, 9, 2, 5.00),
(51, 9, 3, 4.00),
(52, 9, 4, 4.00),
(53, 9, 5, 4.00),
(54, 9, 6, 3.00),
(55, 10, 1, 1.00),
(56, 10, 2, 4.00),
(57, 10, 3, 3.00),
(58, 10, 4, 3.00),
(59, 10, 5, 1.00),
(60, 10, 6, 2.00),
(61, 11, 1, 4.00),
(62, 11, 2, 5.00),
(63, 11, 3, 4.00),
(64, 11, 4, 4.00),
(65, 11, 5, 5.00),
(66, 11, 6, 1.00),
(67, 12, 1, 5.00),
(68, 12, 2, 5.00),
(69, 12, 3, 5.00),
(70, 12, 4, 5.00),
(71, 12, 5, 3.00),
(72, 12, 6, 2.00),
(73, 13, 1, 3.00),
(74, 13, 2, 5.00),
(75, 13, 3, 2.00),
(76, 13, 4, 4.00),
(77, 13, 5, 4.00),
(78, 13, 6, 3.00),
(79, 14, 1, 1.00),
(80, 14, 2, 4.00),
(81, 14, 3, 3.00),
(82, 14, 4, 4.00),
(83, 14, 5, 4.00),
(84, 14, 6, 1.00),
(85, 15, 1, 3.00),
(86, 15, 2, 5.00),
(87, 15, 3, 4.00),
(88, 15, 4, 5.00),
(89, 15, 5, 5.00),
(90, 15, 6, 2.00),
(123, 2, 1, 2.00),
(124, 2, 2, 4.00),
(125, 2, 3, 3.00),
(126, 2, 4, 4.00),
(127, 2, 5, 4.00),
(128, 2, 6, 2.00),
(155, 1, 1, 4.00),
(156, 1, 2, 4.00),
(157, 1, 3, 4.00),
(158, 1, 4, 4.00),
(159, 1, 5, 4.00),
(160, 1, 6, 4.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `criteria`
--

CREATE TABLE `criteria` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('Cost','Benefit') NOT NULL,
  `weight` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `criteria`
--

INSERT INTO `criteria` (`id`, `code`, `name`, `description`, `type`, `weight`) VALUES
(1, 'C1', 'Jumlah Usaha Sejenis', 'Jumlah usaha yang sejenis di sekitar lokasi', 'Cost', 0.20),
(2, 'C2', 'Luas Tanah', 'Luas tanah yang tersedia untuk usaha', 'Benefit', 0.15),
(3, 'C3', 'Keamanan', 'Tingkat keamanan di lokasi usaha', 'Benefit', 0.25),
(4, 'C4', 'Internetan', 'Ketersediaan akses internet', 'Benefit', 0.10),
(5, 'C5', 'Pusat Keramaian', 'Kedekatan dengan pusat keramaian', 'Benefit', 0.20),
(6, 'C6', 'Harga Sewa', 'Harga sewa lokasi usaha', 'Cost', 0.10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subcriteria`
--

CREATE TABLE `subcriteria` (
  `id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `subkriteria` text NOT NULL,
  `description` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `subcriteria`
--

INSERT INTO `subcriteria` (`id`, `criterion_id`, `subkriteria`, `description`, `score`) VALUES
(32, 1, 'Banyak usaha sejenis', 'Lebih dari 6 usaha kopi sejenis', 1),
(33, 1, 'Cukup banyak usaha sejenis', 'Terdapat 5-6 usaha kopi sejenis', 2),
(34, 1, 'Beberapa usaha sejenis', 'Terdapat 3-4 usaha kopi sejenis', 3),
(35, 1, 'Sedikit usaha sejenis', 'Terdapat 1-2 usaha kopi sejenis', 4),
(36, 1, 'Tidak ada usaha sejenis', 'Tidak ada usaha kopi sejenis di area tersebut', 5),
(37, 2, 'Terbatas', '< 50 m² ', 1),
(38, 2, 'Sedang', '50-69 m²', 2),
(39, 2, 'Cukup Luas', '70-99 m² ', 3),
(40, 2, 'Luas', '100-150 m² ', 4),
(41, 2, 'Sangat Luas', '> 150 m² ', 5),
(42, 3, 'Tidak Aman', 'Area rawan, sering terjadi insiden', 1),
(43, 3, 'Kurang Aman', 'Area dengan tingkta keamanan rendah, ada beberapa risiko', 2),
(44, 3, 'Cukup Aman', 'Area dengan tingkat keamanan sedang', 3),
(45, 3, 'Aman', 'Area dengan tingkat kemanan tinggi', 4),
(46, 3, 'Sangat Aman', 'Area dengan tingkat kemanan sangat tinggi, minim risiko', 5),
(47, 4, 'Tidak Tersedia', 'Tidak ada koneksi internet', 1),
(48, 4, 'Kurang', 'Koneksi internet lambat atau sering terputus', 2),
(49, 4, 'Cukup', 'Koneksi internet ada, tapi kurang stabil', 3),
(50, 4, 'Baik', 'Koneksi internet stabil', 4),
(51, 4, 'Sangat Baik', 'Koneksi internet cepat dan stabil', 5),
(57, 6, 'Sangat Mahal', 'Harga sewa lebih dari Rp 20.000.000 per tahun ', 1),
(58, 6, 'Mahal', 'Harga sewa Rp 17.000.000–Rp 19.999.999 per tahun ', 2),
(59, 6, 'Sedang', 'Harga sewa Rp 14.000.000–Rp 16.999.999 per tahun ', 3),
(60, 6, 'Murah', 'Harga sewa Rp 10.000.000–Rp 13.999.999 per tahun ', 4),
(61, 6, 'Sangat Murah', 'Harga sewa kurang dari Rp 10.000.000 per bulan ', 5),
(62, 5, 'Dekat', 'Berjarak kurang dari 500 meter dair pusat keramaian', 1),
(63, 5, 'Cukup Dekat', 'Berjarak 500-1.000 meter dari pusat keramaian', 2),
(64, 5, 'Agak Jauh', 'Berjarak 1.000-1.500 meter dari pusat keramaian', 3),
(65, 5, 'Jauh', 'Berjarak lebih dari 1.500 meter dari pusat keramaian', 4),
(66, 5, 'Sangat Dekat', 'Berada di dalam pusat keramaian', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pimpinan','staff') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin1', 'mufid', 'rizkimufid.rm3@gmail.com', '$2y$10$qON8U12BogkYnjzL1YPYD.z0Qt7juB9egs/ztutEQNjJ7RaWNCVky', 'pimpinan', '2025-01-13 14:54:11'),
(2, 'staff1', 'Staff', 'rizkimufid.rm@gmail.com', '$2y$10$9y75FXGwakzHQB1qwhHtKeeNF4naSABIyiXAF2/YzVmB04lls.9/a', 'staff', '2025-01-13 15:05:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `alternative_values`
--
ALTER TABLE `alternative_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternative_id` (`alternative_id`),
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indeks untuk tabel `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `subcriteria`
--
ALTER TABLE `subcriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `alternative_values`
--
ALTER TABLE `alternative_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT untuk tabel `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `subcriteria`
--
ALTER TABLE `subcriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alternative_values`
--
ALTER TABLE `alternative_values`
  ADD CONSTRAINT `alternative_values_ibfk_1` FOREIGN KEY (`alternative_id`) REFERENCES `alternatives` (`id`),
  ADD CONSTRAINT `alternative_values_ibfk_2` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`);

--
-- Ketidakleluasaan untuk tabel `subcriteria`
--
ALTER TABLE `subcriteria`
  ADD CONSTRAINT `subcriteria_ibfk_1` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
