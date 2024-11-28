-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2024 pada 05.45
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
-- Database: `nganjukkk`
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
-- Trigger `detail_event`
--
DELIMITER $$
CREATE TRIGGER `after_insert_event` AFTER INSERT ON `detail_event` FOR EACH ROW BEGIN
    DECLARE notif_judul VARCHAR(255);
    DECLARE notif_isi VARCHAR(255);
    SET notif_judul = CONCAT('Event Baru: ', NEW.nama);
    SET notif_isi = CONCAT('Akan hadir Event "', NEW.nama, '" jangan sampai lewatin eventnya ya. Lokasi: ', NEW.alamat, '. Tanggal: ', DATE_FORMAT(NEW.tanggal_event, '%d-%m-%Y'));
    INSERT INTO notifikasi (judul, isi, id_user, waktu)
    VALUES (notif_judul, notif_isi, NEW.id_user, CURRENT_TIMESTAMP);
END
$$
DELIMITER ;

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
  `alamat` varchar(255) NOT NULL,
  `koordinat` varchar(255) NOT NULL,
  `link_maps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
CREATE TRIGGER `after_detail_tiket_status_update` AFTER UPDATE ON `detail_tiket` FOR EACH ROW BEGIN
DECLARE wisata_nama VARCHAR(200);
      IF NEW.status = 'berhasil' AND OLD.status != 'berhasil' THEN
        
       
        SELECT nama_wisata INTO wisata_nama 
        FROM detail_wisata 
        WHERE id_wisata = NEW.id_wisata;

       
        INSERT INTO notifikasi (judul, isi, id_user, waktu)
        VALUES (
            CONCAT('Tiket Wisata: ', wisata_nama), 
            CONCAT('Selamat Pembayaran Tiket Wisata: ', wisata_nama, ' Berhasil terkonfirmasi!!! Anda sekarang dapat melihat informasi tiketnya di menu Booking, tunjukkan pada petugas penjaga loket saat ingin memasuki wisata.'),
            NEW.id_user,
            NOW()
        );
    END IF;
END
$$
DELIMITER ;
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
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_penginapan`
--

CREATE TABLE `ulasan_penginapan` (
  `id_ulasan_p` int(11) NOT NULL,
  `id_penginapan` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
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
  `tanggal` date NOT NULL,
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
(9, 'bahrulahmad1945@gmail.com', 'bahrul ', 'admin', '$2y$10$x8zC/wB50wepYtrSdMnivOXkNnWbtVv3iQT2cGvROw0YdBbycQuhW', 'Nganjuk sini aja', '9_1732285680.png', '32612796', '2024-11-24 15:05:06', 'active', NULL, '');

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
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `notif_user` (`id_user`);

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
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `detail_kuliner`
--
ALTER TABLE `detail_kuliner`
  MODIFY `id_kuliner` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `detail_penginapan`
--
ALTER TABLE `detail_penginapan`
  MODIFY `id_penginapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `detail_tiket`
--
ALTER TABLE `detail_tiket`
  MODIFY `id_detail_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_wisata`
--
ALTER TABLE `detail_wisata`
  MODIFY `id_wisata` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `fav_kuliner`
--
ALTER TABLE `fav_kuliner`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `fav_penginapan`
--
ALTER TABLE `fav_penginapan`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `fav_wisata`
--
ALTER TABLE `fav_wisata`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `riwayat_transaksi_tiket_wisata`
--
ALTER TABLE `riwayat_transaksi_tiket_wisata`
  MODIFY `id_transaksi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tiket_wisata`
--
ALTER TABLE `tiket_wisata`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `ulasan_penginapan`
--
ALTER TABLE `ulasan_penginapan`
  MODIFY `id_ulasan_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ulasan_wisata`
--
ALTER TABLE `ulasan_wisata`
  MODIFY `id_ulasan_w` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notif_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

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

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `hapus_notifikasi_lama` ON SCHEDULE EVERY 1 DAY STARTS '2024-11-26 10:00:32' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM notifikasi
    WHERE waktu < NOW() - INTERVAL 7 DAY;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
