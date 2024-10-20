-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2024 pada 10.24
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
(5, 'Hotel Nganjuk', 9, 'Ini adalah hotel yang halal di Nganjuk', '50000', 'Guyangan', 'IMG_20180820_215510.jpg,IMG_20180823_070816.jpg,IMG_20180823_135115.jpg', '0182917381');

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
  `id_pengelola` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_wisata`
--

INSERT INTO `detail_wisata` (`id_wisata`, `nama_wisata`, `id_user`, `deskripsi`, `alamat`, `harga_tiket`, `jadwal`, `gambar`, `koordinat`, `link_maps`, `id_pengelola`) VALUES
(21, 'Roro Kuning Nganjuk', 9, 'ini adalah wisata yang ada di nganjuk', 'nganjuk sawahan', '12000', '121', '670e8d5b68270.png,670fb8d63ded9.png', '12232', 'https://maps.app.goo.gl/7cf8TZzykJcJnCr86', 21),
(22, 'Sedudo', 9, 'Pesona Nganjuk', 'nganjuk sawahan', '20000', '12', '670fb9c55e724.png,670fb9c55e953.png,670fb9dd7a07c.png,670fb9dd7a2eb.png', 'sss', 'https://maps.app.goo.gl/vbtbTSRUYFAi4ZeE7', 25),
(23, 'singokromo', 9, 'bagus', 'sebelum jembatan', '12000', '12-32', '670fbf548416b.png,670fbf54843af.png,670fbf54845d7.png,670fbf54847e7.png', 'qwdq', 'https://maps.app.goo.gl/vbtbTSRUYFAi4ZeE7', 26);

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

--
-- Dumping data untuk tabel `fav_wisata`
--

INSERT INTO `fav_wisata` (`id_fav`, `id_wisata`, `id_user`) VALUES
(2, 22, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_transaksi_tiket_wisata`
--

CREATE TABLE `riwayat_transaksi_tiket_wisata` (
  `id_transaksi` int(12) NOT NULL,
  `nama_wisata` varchar(200) NOT NULL,
  `jumlah_tiket` int(12) NOT NULL,
  `harga_tiket` int(12) NOT NULL,
  `total` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_transaksi_tiket_wisata`
--

INSERT INTO `riwayat_transaksi_tiket_wisata` (`id_transaksi`, `nama_wisata`, `jumlah_tiket`, `harga_tiket`, `total`) VALUES
(1, 'Roro Kuning Nganjuk', 3, 12000, 36000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket_wisata`
--

CREATE TABLE `tiket_wisata` (
  `id_tiket` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nama_wisata` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pengelola_wisata` int(11) NOT NULL,
  `harga_tiket` int(12) NOT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `total` int(12) NOT NULL,
  `bayar` int(12) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `no_wa` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket_wisata`
--

INSERT INTO `tiket_wisata` (`id_tiket`, `id_wisata`, `nama_wisata`, `id_user`, `id_pengelola_wisata`, `harga_tiket`, `jumlah_tiket`, `total`, `bayar`, `kembalian`, `no_wa`) VALUES
(2, 21, 'Roro Kuning Nganjuk', 33, 21, 12000, 3, 36000, 40000, 4000, '123456789');

--
-- Trigger `tiket_wisata`
--
DELIMITER $$
CREATE TRIGGER `after_insert_tiket_wisata` AFTER INSERT ON `tiket_wisata` FOR EACH ROW BEGIN
    INSERT INTO riwayat_transaksi_tiket_wisata (
        nama_wisata, 
        jumlah_tiket, 
        harga_tiket, 
        total
    ) VALUES (
        NEW.nama_wisata, 
        NEW.jumlah_tiket, 
        NEW.harga_tiket, 
        NEW.total
    );
END
$$
DELIMITER ;

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
  `no_hp` varchar(50) NOT NULL
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
(21, 'eskuwut1945@gmail.com', 'okeoke bagus', 'pengelola', '$2y$10$bjJFyxBXQ4rRrdOL5t8I0OAwg49mnSBlhIo4LMu/dy2zGRdHd3njC', 'jauhh disanaaa\r\n', '21_1729344014.jpg', '86875398', '2024-10-17 17:54:41', 'active', '21', '123456789'),
(22, 'tespengelola@gmail.com', 'pengelola', 'pengelola', '$2y$10$SVlj6ms7Y7rlThPeNsy6WuadAAB6/msDgOlbUgjFfsL4MoQQCtZ8e', 'hahaha', '670164b4564fe.png', NULL, NULL, 'inactive', '21', ''),
(24, 'tesbroo@gmail.com', 'testing lagi', 'pengelola', '$2y$10$FAZu24O4B6nG.asGM9EmQeO4rxonmNhYi7ooPoUqmAVzUxweNSEjO', 'qwertyuiop', NULL, NULL, NULL, 'inactive', NULL, '123456789111'),
(25, 'sedudo@gmail.com', 'halo gais', 'pengelola', '$2y$10$zrbYICVcAEmp1X3PP5n1HuGEz2I2EIGPPn5dfXYenrmjs7L0Etwx.', 'hh', '6709318f037be.png', NULL, NULL, 'active', '22', ''),
(26, 'singokromo@gmail.com', 'singokromo', 'pengelola', '$2y$10$SZ7VjSVuwJiPjSCYei7rSuuQLXO6SUE/P/Qhlsymug3HnpW8ZpUYW', 'jauh disana', '670fbf1f0e27d.png', NULL, NULL, 'active', '23', ''),
(33, 'user@gmail.com', 'user', 'user', 'user12345', 'alamat user', NULL, NULL, NULL, 'active', NULL, '');

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
  ADD PRIMARY KEY (`id_transaksi`);

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
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  MODIFY `id_kuliner` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  MODIFY `id_penginapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  MODIFY `id_wisata` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id_transaksi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
