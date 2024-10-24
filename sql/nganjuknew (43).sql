-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Okt 2024 pada 16.47
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
-- Database: `nganjuknew`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_event`
--

CREATE TABLE `detail_event` (
  `id_event` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi_event` text NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `tanggal_event` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_kuliner`
--

CREATE TABLE `detail_kuliner` (
  `id_kuliner` int(12) NOT NULL,
  `nama_kuliner` varchar(255) NOT NULL,
  `id_user` int(12) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` varchar(200) NOT NULL,
  `gambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_kuliner`
--

INSERT INTO `detail_kuliner` (`id_kuliner`, `nama_kuliner`, `id_user`, `deskripsi`, `harga`, `gambar`) VALUES
(21, 'sate', 9, 'ayam di bakar', '30000', 'Screenshot (7).png,Screenshot (12).png,Screenshot (19).png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penginapan`
--

CREATE TABLE `detail_penginapan` (
  `id_penginapan` int(11) NOT NULL,
  `nama_penginapan` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` varchar(200) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `telepon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_penginapan`
--

INSERT INTO `detail_penginapan` (`id_penginapan`, `nama_penginapan`, `id_user`, `deskripsi`, `harga`, `lokasi`, `gambar`, `telepon`) VALUES
(5, 'Hotel Nganjuk', 9, 'Ini adalah hotel yang halal di Nganjuk', '50000', 'JAUHHHHHHHHH', 'IMG_20180820_215510.jpg,IMG_20180823_070816.jpg,IMG_20180823_135115.jpg', '0182917381');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_tiket`
--

CREATE TABLE `detail_tiket` (
  `id_detail_tiket` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `harga` varchar(12) NOT NULL,
  `jumlah` int(12) NOT NULL,
  `total` int(12) NOT NULL,
  `bayar` int(12) NOT NULL,
  `kembalian` int(12) NOT NULL,
  `status` enum('berhasil','gagal','diproses') NOT NULL DEFAULT 'diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_tiket`
--

INSERT INTO `detail_tiket` (`id_detail_tiket`, `id_tiket`, `id_user`, `id_wisata`, `harga`, `jumlah`, `total`, `bayar`, `kembalian`, `status`) VALUES
(2, 11, 9, 32, '40000', 2, 80000, 80000, 20000, 'gagal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_wisata`
--

CREATE TABLE `detail_wisata` (
  `id_wisata` int(12) NOT NULL,
  `nama_wisata` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `harga_tiket` varchar(255) NOT NULL,
  `jadwal` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `koordinat` varchar(255) NOT NULL,
  `link_maps` varchar(255) NOT NULL,
  `id_pengelola` int(12) DEFAULT NULL,
  `no_hp_pengelola` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_wisata`
--

INSERT INTO `detail_wisata` (`id_wisata`, `nama_wisata`, `id_user`, `deskripsi`, `alamat`, `harga_tiket`, `jadwal`, `gambar`, `koordinat`, `link_maps`, `id_pengelola`, `no_hp_pengelola`) VALUES
(32, 'tes coba haha', 9, 'tesss', 'tessssss', '40000', 'senin: 08:45-20:31, selasa: 09:40-21:40, rabu: 09:40-21:40, kamis: 09:40-21:40, jumat: 09:40-21:40, sabtu: 09:40-21:40, minggu: -', '671863582d8f9.jpg', '2343', 'https://maps.app.goo.gl/8ZYXSXJ7FcKShH3a9', 37, '11111111111');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fav_kuliner`
--

CREATE TABLE `fav_kuliner` (
  `id_fav` int(11) NOT NULL,
  `id_kuliner` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fav_kuliner`
--

INSERT INTO `fav_kuliner` (`id_fav`, `id_kuliner`, `id_user`) VALUES
(1, 21, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fav_penginapan`
--

CREATE TABLE `fav_penginapan` (
  `id_fav` int(11) NOT NULL,
  `id_penginapan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fav_penginapan`
--

INSERT INTO `fav_penginapan` (`id_fav`, `id_penginapan`, `id_user`) VALUES
(2, 5, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fav_wisata`
--

CREATE TABLE `fav_wisata` (
  `id_fav` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_transaksi_tiket_wisata`
--

CREATE TABLE `riwayat_transaksi_tiket_wisata` (
  `id_transaksi` int(12) NOT NULL,
  `id_detail_tiket` int(12) NOT NULL,
  `nama_wisata` varchar(200) NOT NULL,
  `jumlah_tiket` int(12) NOT NULL,
  `harga_tiket` int(12) NOT NULL,
  `total` int(12) NOT NULL,
  `status` enum('berhasil','gagal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_transaksi_tiket_wisata`
--

INSERT INTO `riwayat_transaksi_tiket_wisata` (`id_transaksi`, `id_detail_tiket`, `nama_wisata`, `jumlah_tiket`, `harga_tiket`, `total`, `status`) VALUES
(6, 2, 'tes coba haha', 2, 40000, 80000, 'berhasil'),
(7, 2, 'tes coba haha', 2, 40000, 80000, 'berhasil'),
(8, 2, 'tes coba haha', 2, 40000, 80000, 'berhasil'),
(9, 2, 'tes coba haha', 2, 40000, 80000, 'gagal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket_wisata`
--

CREATE TABLE `tiket_wisata` (
  `id_tiket` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nama_wisata` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `harga_tiket` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket_wisata`
--

INSERT INTO `tiket_wisata` (`id_tiket`, `id_wisata`, `nama_wisata`, `id_user`, `harga_tiket`) VALUES
(11, 32, 'tes coba haha', 9, 40000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_kuliner`
--

CREATE TABLE `ulasan_kuliner` (
  `id_ulasan_k` int(11) NOT NULL,
  `id_kuliner` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'ulasan_kuliner',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_penginapan`
--

CREATE TABLE `ulasan_penginapan` (
  `id_ulasan_p` int(11) NOT NULL,
  `id_penginapan` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'ulasan_penginapan',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_wisata`
--

CREATE TABLE `ulasan_wisata` (
  `id_ulasan_w` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'ulasan_wisata',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role` enum('admin','pengelola','user') NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kode_otp` varchar(50) DEFAULT NULL,
  `expired_otp` datetime DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `ket_wisata` varchar(200) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `email`, `nama`, `role`, `password`, `alamat`, `gambar`, `kode_otp`, `expired_otp`, `status`, `ket_wisata`, `no_hp`) VALUES
(5, 'esjeruk517@gmail.com', 'bahrul', 'admin', '$2y$10$e3JqdgSNaDBcIvjnvMVWl.CN0U6neesp8T2G6kqEFv/SCOssQGgZS', 'hhh', NULL, '934115', NULL, 'active', NULL, ''),
(6, 'esvanilla63@gmail.com', 'bahrul', 'admin', '$2y$10$8r7M1SakdsOYEUqFKc1ck.s0U6MCHpeRdrpB8oo.6jjx8SIoje1tG', 'hhhh', NULL, '70076637', '2024-09-15 15:46:21', 'active', NULL, ''),
(7, 'r882357@gmail.com', 'Ratna Indah Anggraini ', 'admin', '$2y$10$Lb/n7Z6sMzMrjdcZSb3jweu76/NS/tXpa7q6ZT/XEkFHcSvJxY1UC', 'ked', NULL, '17056642', '2024-09-18 05:54:28', 'active', NULL, ''),
(8, 'riandafaturahman@gmail.com', 'Rianda', 'admin', '$2y$10$UXKqMEL14aAHhJ3aScq2/eppHN/mqTMpgY4QsBibT3dLeSjSC892u', 'jl', NULL, '77123080', '2024-09-20 04:51:05', 'active', NULL, ''),
(9, 'bahrulahmad@gmail.com', 'bahrul testing', 'admin', '$2y$10$7AcxgYJwWdyHwhTTbGwJq.DnTKSIRBb.TDlK9s8qGdDWvY.5C1CbC', 'Nganjuk sini aja', '9_1729345424.jpg', NULL, NULL, 'active', NULL, ''),
(12, 'amardjidan@gmail.com', 'amar', 'admin', '$2y$10$cb5uBupsKXMjAUC8wZtC..VsYOjHlGmv.RYHb2d6gWzK/kD075ILm', 'tanjunganom', NULL, '14232161', '2024-09-24 10:06:52', 'active', NULL, ''),
(22, 'tespengelola@gmail.com', 'pengelola', 'pengelola', '$2y$10$SVlj6ms7Y7rlThPeNsy6WuadAAB6/msDgOlbUgjFfsL4MoQQCtZ8e', 'hahaha', '670164b4564fe.png', NULL, NULL, 'inactive', '21', ''),
(24, 'tesbroo@gmail.com', 'testing lagi', 'pengelola', '$2y$10$FAZu24O4B6nG.asGM9EmQeO4rxonmNhYi7ooPoUqmAVzUxweNSEjO', 'qwertyuiop', NULL, NULL, NULL, 'inactive', NULL, '123456789111'),
(33, 'user@gmail.com', 'user', 'user', 'user12345', 'alamat user', NULL, NULL, NULL, 'active', NULL, ''),
(34, 'user123@gmail.com', 'usertesAPI', 'user', '$2y$10$4fd42fkI3MiK81a2RJbBcOdcghOEEecmfecfHpKh62uSV4gBqGHxu', 'tesalamatuserya', NULL, NULL, NULL, 'active', NULL, NULL),
(35, 'user12345@gmail.com', 'tes api user bro', 'user', '$2y$10$6CMffVkMnu.BSlWEI2f4Qeu1Eh/nnVvHADehqrpy6mtPUPvy03WFi', 'alamat baru api', NULL, NULL, NULL, 'active', NULL, NULL),
(36, 'user123456789@gmail.com', 'tes api user terakhir put lagi', 'user', '$2y$10$SsUCL14XAVTR5Ej6zAjnpeB33WpSrFMSpvSlrxVW2nNVOda/eiPiO', 'alamat baru api terakhir patch', NULL, NULL, NULL, 'active', NULL, NULL),
(37, 'eskuwut1945@gmail.com', 'halo gais', 'pengelola', '$2y$10$A.x8ZbQrv0JBLuNrEG6OZuuTIRbGJgFqTZbyfxyjIq3v.y6bVR2Mq', 'h', '67184a44d934e.jpg', '12114732', '2024-10-23 03:38:06', 'active', '32', '11111111111');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_event`
--
ALTER TABLE `detail_event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `user_event` (`id_user`);

--
-- Indeks untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  ADD PRIMARY KEY (`id_kuliner`),
  ADD KEY `user_kuliner` (`id_user`);

--
-- Indeks untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  ADD PRIMARY KEY (`id_penginapan`),
  ADD KEY `user_penginapan` (`id_user`);

--
-- Indeks untuk tabel `detail_tiket`
--
ALTER TABLE `detail_tiket`
  ADD PRIMARY KEY (`id_detail_tiket`),
  ADD KEY `tiket_id` (`id_tiket`),
  ADD KEY `wisata_id` (`id_wisata`),
  ADD KEY `user_id` (`id_user`);

--
-- Indeks untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  ADD PRIMARY KEY (`id_wisata`),
  ADD KEY `user_wisata` (`id_user`);

--
-- Indeks untuk tabel `fav_kuliner`
--
ALTER TABLE `fav_kuliner`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `fav_kuliner` (`id_kuliner`),
  ADD KEY `fav_user_kuliner` (`id_user`);

--
-- Indeks untuk tabel `fav_penginapan`
--
ALTER TABLE `fav_penginapan`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `fav_penginapan` (`id_penginapan`),
  ADD KEY `fav_user_penginapan` (`id_user`);

--
-- Indeks untuk tabel `fav_wisata`
--
ALTER TABLE `fav_wisata`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `fav_wisata` (`id_wisata`),
  ADD KEY `fav_user_wisata` (`id_user`);

--
-- Indeks untuk tabel `riwayat_transaksi_tiket_wisata`
--
ALTER TABLE `riwayat_transaksi_tiket_wisata`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `tiket_detail_id` (`id_detail_tiket`);

--
-- Indeks untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `tiket_wisata` (`id_wisata`),
  ADD KEY `user_tiket` (`id_user`);

--
-- Indeks untuk tabel `ulasan_kuliner`
--
ALTER TABLE `ulasan_kuliner`
  ADD PRIMARY KEY (`id_ulasan_k`),
  ADD KEY `ulasan_user_k` (`id_user`),
  ADD KEY `ulasan_id_k` (`id_kuliner`);

--
-- Indeks untuk tabel `ulasan_penginapan`
--
ALTER TABLE `ulasan_penginapan`
  ADD PRIMARY KEY (`id_ulasan_p`),
  ADD KEY `ulasan_id_p` (`id_penginapan`),
  ADD KEY `ulasan_user_p` (`id_user`);

--
-- Indeks untuk tabel `ulasan_wisata`
--
ALTER TABLE `ulasan_wisata`
  ADD PRIMARY KEY (`id_ulasan_w`),
  ADD KEY `ulasan_user_w` (`id_user`),
  ADD KEY `ulasan_id_w` (`id_wisata`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_event`
--
ALTER TABLE `detail_event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  MODIFY `id_kuliner` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  MODIFY `id_penginapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_tiket`
--
ALTER TABLE `detail_tiket`
  MODIFY `id_detail_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  MODIFY `id_wisata` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `fav_kuliner`
--
ALTER TABLE `fav_kuliner`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `fav_penginapan`
--
ALTER TABLE `fav_penginapan`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `fav_wisata`
--
ALTER TABLE `fav_wisata`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `riwayat_transaksi_tiket_wisata`
--
ALTER TABLE `riwayat_transaksi_tiket_wisata`
  MODIFY `id_transaksi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `ulasan_kuliner`
--
ALTER TABLE `ulasan_kuliner`
  MODIFY `id_ulasan_k` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ulasan_penginapan`
--
ALTER TABLE `ulasan_penginapan`
  MODIFY `id_ulasan_p` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ulasan_wisata`
--
ALTER TABLE `ulasan_wisata`
  MODIFY `id_ulasan_w` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_event`
--
ALTER TABLE `detail_event`
  ADD CONSTRAINT `user_event` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  ADD CONSTRAINT `user_kuliner` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  ADD CONSTRAINT `user_penginapan` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_tiket`
--
ALTER TABLE `detail_tiket`
  ADD CONSTRAINT `tiket_id` FOREIGN KEY (`id_tiket`) REFERENCES `tiket_wisata` (`id_tiket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wisata_id` FOREIGN KEY (`id_wisata`) REFERENCES `detail_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  ADD CONSTRAINT `user_wisata` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fav_kuliner`
--
ALTER TABLE `fav_kuliner`
  ADD CONSTRAINT `fav_kuliner` FOREIGN KEY (`id_kuliner`) REFERENCES `detail_kuliner` (`id_kuliner`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_user_kuliner` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fav_penginapan`
--
ALTER TABLE `fav_penginapan`
  ADD CONSTRAINT `fav_penginapan` FOREIGN KEY (`id_penginapan`) REFERENCES `detail_penginapan` (`id_penginapan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_user_penginapan` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fav_wisata`
--
ALTER TABLE `fav_wisata`
  ADD CONSTRAINT `fav_user_wisata` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_wisata` FOREIGN KEY (`id_wisata`) REFERENCES `detail_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `riwayat_transaksi_tiket_wisata`
--
ALTER TABLE `riwayat_transaksi_tiket_wisata`
  ADD CONSTRAINT `tiket_detail_id` FOREIGN KEY (`id_detail_tiket`) REFERENCES `detail_tiket` (`id_detail_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  ADD CONSTRAINT `tiket_wisata` FOREIGN KEY (`id_wisata`) REFERENCES `detail_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_tiket` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan_kuliner`
--
ALTER TABLE `ulasan_kuliner`
  ADD CONSTRAINT `ulasan_id_k` FOREIGN KEY (`id_kuliner`) REFERENCES `detail_kuliner` (`id_kuliner`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasan_user_k` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan_penginapan`
--
ALTER TABLE `ulasan_penginapan`
  ADD CONSTRAINT `ulasan_id_p` FOREIGN KEY (`id_penginapan`) REFERENCES `detail_penginapan` (`id_penginapan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasan_user_p` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan_wisata`
--
ALTER TABLE `ulasan_wisata`
  ADD CONSTRAINT `ulasan_id_w` FOREIGN KEY (`id_wisata`) REFERENCES `detail_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasan_user_w` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
