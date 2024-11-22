-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2024 pada 04.14
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
  `alamat` varchar(255) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `tanggal_event` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_event`
--

INSERT INTO `detail_event` (`id_event`, `nama`, `id_user`, `deskripsi_event`, `alamat`, `gambar`, `tanggal_event`) VALUES
(9, 'Siraman Sedudo', 9, 'ritual ngumbah anu', 'ujbswjcebwj', '673562f3202a8_index4-besar.png', '2024-11-14');

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
  `gambar` varchar(200) NOT NULL,
  `total_rating` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_kuliner`
--

INSERT INTO `detail_kuliner` (`id_kuliner`, `nama_kuliner`, `id_user`, `deskripsi`, `harga`, `gambar`, `total_rating`) VALUES
(25, 'Nasi Becel', 9, 'Makanan enak tapi agak mahal sih wkwkwkwkwkwkwk anjayyyyyyyyyyyy', '50000', '673561046b303_index1-besar.png', 0);

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
  `koordinat` varchar(255) DEFAULT NULL,
  `link_maps` varchar(255) DEFAULT NULL,
  `telepon` varchar(100) NOT NULL,
  `total_rating` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_penginapan`
--

INSERT INTO `detail_penginapan` (`id_penginapan`, `nama_penginapan`, `id_user`, `deskripsi`, `harga`, `lokasi`, `gambar`, `koordinat`, `link_maps`, `telepon`, `total_rating`) VALUES
(7, 'Hotel Omahku', 9, 'apik ki koyok e, murah', '300000', 'Nganjuk', '6735618e0ba5c_index2-besar.png', 'rfyujubguigy7887', 'https://maps.app.goo.gl/vbtbTSRUYFAi4ZeE7', '1234567890', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_tiket`
--

CREATE TABLE `detail_tiket` (
  `id_detail_tiket` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `jumlah` int(12) NOT NULL,
  `total` int(12) NOT NULL,
  `bayar` int(12) NOT NULL,
  `kembalian` int(12) NOT NULL,
  `status` enum('berhasil','gagal','diproses','digunakan') NOT NULL DEFAULT 'diproses',
  `waktu_konfirmasi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `detail_tiket`
--
DELIMITER $$
CREATE TRIGGER `update_total` BEFORE INSERT ON `detail_tiket` FOR EACH ROW BEGIN
    SET NEW.total = NEW.harga * NEW.jumlah;
END
$$
DELIMITER ;

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
  `no_hp_pengelola` varchar(50) DEFAULT NULL,
  `total_rating` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_wisata`
--

INSERT INTO `detail_wisata` (`id_wisata`, `nama_wisata`, `id_user`, `deskripsi`, `alamat`, `harga_tiket`, `jadwal`, `gambar`, `koordinat`, `link_maps`, `id_pengelola`, `no_hp_pengelola`, `total_rating`) VALUES
(39, 'Roro Kuning', 9, 'Roro Kuning adalah destinasi wisata alam di Nganjuk, Jawa Timur, yang terkenal dengan keindahan air terjun yang mengalir di antara tebing hijau dan suasana alami yang asri.', 'Sawahan, Nganjuk', '20000', 'senin: 09:19-21:19, selasa: 09:19-21:19, rabu: 09:21-21:19, kamis: 09:19-21:19, jumat: 09:19-21:19, sabtu: 09:19-21:19, minggu: 09:19-21:19', '67355e61a2d4a_index3-besar.png', '-7.599090314279133, 111.87815532081424', 'qdwudbqwbdiqw', 43, '1234567890', 0),
(41, 'tes', 9, 'sdas', 'adada', '122', 'Senin: 21:05-09:05, Selasa: -, Rabu: -, Kamis: -, Jumat: -, Sabtu: -, Minggu: -', '673f3e675dd85_20241116_211252.jpg', '-7.599090314279133, 111.87815532081424', 'https://maps.app.goo.gl/7cf8TZzykJcJnCr86', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fav_kuliner`
--

CREATE TABLE `fav_kuliner` (
  `id_fav` int(11) NOT NULL,
  `id_kuliner` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fav_penginapan`
--

CREATE TABLE `fav_penginapan` (
  `id_fav` int(11) NOT NULL,
  `id_penginapan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` enum('berhasil','gagal') NOT NULL,
  `tanggal_transaksi` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 39, 'Roro Kuning', 9, 20000);

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
  `id_user` int(11) NOT NULL,
  `rating` float DEFAULT 0
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
  `id_user` int(11) NOT NULL,
  `rating` float DEFAULT 0
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
(9, 'bahrulahmad1945@gmail.com', 'bahrul ', 'admin', '$2y$10$TY51tS1/hLH7tEng0FTBsO6El0RSvfPfY7/QU5g.SopsPVWiYQmRq', 'Nganjuk sini aja', '9_1730942971.png', '11882792', '2024-11-22 03:01:16', 'active', NULL, ''),
(39, 'igvi@gmail.com', 'igvi', 'user', '$2y$10$5L3JlK3OyKhB6F7Khp0UsuvxY6RAdm31gqgf9WiT8Lo1f5NR69Jei', 'Bagor', 'igvi.png', NULL, NULL, 'active', NULL, '085606650827'),
(43, 'eskuwut1945@gmail.com', 'Pengelola', 'pengelola', '$2y$10$p5kkeiTYdXo3MjUxjz7xKeqf285YaxnYUvyFPWordkCYbgU4.D8ia', 'Nganjuk', '672c1a0c4b465.png', '69637754', '2024-11-09 14:22:31', 'active', '39', '1234567890'),
(49, 'dianashafa@gmail.com', 'diana', 'pengelola', '$2y$10$DOlA0wF.vOEa.XK9LIOw9efdiYOQnWVpsV67MxFcKuOrIyiqPopxS', 'kauman', NULL, NULL, NULL, 'active', NULL, '085774831924'),
(50, 'esvanilla63@gmail.com', 'vanilla', 'pengelola', '$2y$10$kUlxi1Z39IQnbYwOKHjGKe7L5uevVmqoLpkY/zsGjlJL0GbWakSbm', 'adsadsad', NULL, NULL, NULL, 'active', NULL, '5432561788');

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
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  MODIFY `id_kuliner` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  MODIFY `id_penginapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_tiket`
--
ALTER TABLE `detail_tiket`
  MODIFY `id_detail_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  MODIFY `id_wisata` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `fav_kuliner`
--
ALTER TABLE `fav_kuliner`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `fav_penginapan`
--
ALTER TABLE `fav_penginapan`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `fav_wisata`
--
ALTER TABLE `fav_wisata`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `riwayat_transaksi_tiket_wisata`
--
ALTER TABLE `riwayat_transaksi_tiket_wisata`
  MODIFY `id_transaksi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `ulasan_penginapan`
--
ALTER TABLE `ulasan_penginapan`
  MODIFY `id_ulasan_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ulasan_wisata`
--
ALTER TABLE `ulasan_wisata`
  MODIFY `id_ulasan_w` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
