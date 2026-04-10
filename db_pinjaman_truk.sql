-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Apr 2026 pada 08.38
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pinjaman_truk`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_denda` (`tgl_rencana` DATE, `tgl_aktual` DATE) RETURNS INT(11) BEGIN
    DECLARE selisih INT;
    SET selisih = DATEDIFF(tgl_aktual, tgl_rencana);
    IF selisih > 0 THEN
        RETURN selisih * 200000;
    ELSE
        RETURN 0;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_truk`
--

CREATE TABLE `kategori_truk` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori_truk`
--

INSERT INTO `kategori_truk` (`id_kategori`, `nama_kategori`) VALUES
(5, 'Pick Up'),
(6, 'Blind Van'),
(8, 'Engkel (CDE)'),
(9, 'Double (CDD)'),
(10, 'Fuso'),
(11, 'Tronton'),
(12, 'Wingbox'),
(13, 'Tractor Unit'),
(14, 'Truk Tanki'),
(15, 'Tow');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu`) VALUES
(1, 3, 'Mengembalikan truk AS 9780 VC dengan denda Rp 0', '2026-02-06 09:25:36'),
(2, 5, 'Mengembalikan truk AD 8770 VC dengan denda Rp 0', '2026-02-11 13:15:34'),
(3, 5, 'Mengembalikan truk DK 8871 AB dengan denda Rp 0', '2026-02-11 13:15:47'),
(4, 5, 'Mengembalikan truk K 6672 OPD dengan denda Rp 0', '2026-02-25 14:28:49'),
(5, 5, 'Mengembalikan truk AD 8770 VC dengan denda Rp 0', '2026-02-26 12:02:51'),
(6, 5, 'Mengembalikan truk AD 8890 VC dengan denda Rp 0', '2026-02-26 12:02:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_truk` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali_rencana` date DEFAULT NULL,
  `status_approval` enum('Pending','Disetujui','Ditolak','Selesai') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_user`, `id_truk`, `tgl_pinjam`, `tgl_kembali_rencana`, `status_approval`) VALUES
(2, 6, 2, '2026-02-10', '2026-12-12', 'Ditolak'),
(3, 6, 2, '2026-02-10', '1212-12-12', 'Disetujui'),
(4, 5, 17, '2026-02-11', '2026-11-22', 'Selesai'),
(5, 5, 3, '2026-02-11', '2026-12-12', 'Selesai'),
(6, 5, 11, '2026-02-25', '2026-03-04', 'Selesai'),
(7, 5, 9, '2026-02-25', '2026-02-28', 'Selesai'),
(8, 5, 3, '2026-02-26', '2026-05-12', 'Selesai'),
(9, 5, 3, '2026-02-26', '2026-02-26', 'Disetujui'),
(10, 5, 9, '2026-02-26', '2026-02-26', 'Disetujui'),
(11, 7, 17, '2026-03-03', '2026-03-03', 'Disetujui');

--
-- Trigger `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `tr_setujui_pinjam` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
    IF NEW.status_approval = 'Disetujui' THEN
        UPDATE truk SET status = 'Dipinjam' WHERE id_truk = NEW.id_truk;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_kembali` int(11) NOT NULL,
  `id_pinjam` int(11) DEFAULT NULL,
  `tgl_kembali_aktual` date DEFAULT NULL,
  `denda` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_kembali`, `id_pinjam`, `tgl_kembali_aktual`, `denda`) VALUES
(2, 5, '2026-02-11', 0),
(3, 4, '2026-02-11', 0),
(4, 6, '2026-02-25', 0),
(5, 8, '2026-02-26', 0),
(6, 7, '2026-02-26', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `truk`
--

CREATE TABLE `truk` (
  `id_truk` int(11) NOT NULL,
  `plat_nomor` varchar(20) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `harga_per_hari` int(11) DEFAULT NULL,
  `status` enum('Tersedia','Dipinjam','Perbaikan') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `truk`
--

INSERT INTO `truk` (`id_truk`, `plat_nomor`, `merk`, `id_kategori`, `harga_per_hari`, `status`) VALUES
(2, 'AD 9780 VC', 'Scania 4 Series', 13, 1500000, 'Dipinjam'),
(3, 'AD 8770 VC', 'Suzuki New Carry', 5, 350000, 'Dipinjam'),
(4, 'B 9012 TKA', 'Mitsubishi Fuso Fighter', 10, 1000000, 'Tersedia'),
(5, 'L 4456 UIO', 'Hino Ranger', 11, 1000000, 'Tersedia'),
(6, 'D 2231 BCT', 'Isuzu Giga Wingbox', 12, 1500000, 'Tersedia'),
(7, 'B 7789 PLK', 'Volvo FH16', 13, 1500000, 'Tersedia'),
(8, 'N 1022 JKL', 'Hino Dutro Tanki', 14, 1250000, 'Tersedia'),
(9, 'AD 8890 VC', 'Isuzu Traga', 5, 350000, 'Dipinjam'),
(10, 'B 3341 XCV', 'Mercedes-Benz Axor', 11, 1000000, 'Tersedia'),
(11, 'K 6672 OPD', 'Toyota Dyna', 8, 600000, 'Tersedia'),
(12, 'B 9912 SQA', 'Scania R580', 13, 1500000, 'Tersedia'),
(13, 'L 8022 UX', 'UD Trucks Quester', 12, 1500000, 'Tersedia'),
(14, 'D 4411 BBN', 'Mitsubishi Colt Diesel', 8, 600000, 'Tersedia'),
(15, 'H 1123 KJG', 'Hino 500 New Gen', 11, 1000000, 'Tersedia'),
(16, 'B 2290 PLM', 'Isuzu Elf NLR', 5, 350000, 'Perbaikan'),
(17, 'DK 8871 AB', 'Toyota Hilux Single Cab', 5, 350000, 'Dipinjam'),
(18, 'KT 1022 RT', 'MAN TGX', 13, 1500000, 'Tersedia'),
(19, 'KH 4451 LP', 'Mercedes-Benz Actros', 11, 1000000, 'Tersedia'),
(20, 'B 9002 WQE', 'Hino Profia', 12, 1500000, 'Tersedia'),
(21, 'L 3321 MN', 'Mitsubishi Fuso Canter', 9, 600000, 'Tersedia'),
(22, 'B 6671 UI', 'Faw Tiger', 8, 600000, 'Tersedia'),
(23, 'D 7782 VC', 'Tata Prima', 13, 1500000, 'Tersedia'),
(24, 'N 5542 XZ', 'Isuzu Giga FVR', 10, 1000000, 'Tersedia'),
(25, 'H 9910 MK', 'Scania P360', 14, 1250000, 'Tersedia'),
(26, 'B 1120 FFA', 'Hino Dutro Towing', 15, 900000, 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','Petugas','Peminjam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'Admin'),
(2, 'petugas', 'petugas', 'Petugas'),
(5, 'Nadhif', 'nadhif', 'Peminjam'),
(6, 'admin_ganteng', 'h', 'Peminjam'),
(7, 'Luci ', 'Arya', 'Peminjam');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori_truk`
--
ALTER TABLE `kategori_truk`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_truk` (`id_truk`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indeks untuk tabel `truk`
--
ALTER TABLE `truk`
  ADD PRIMARY KEY (`id_truk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori_truk`
--
ALTER TABLE `kategori_truk`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `truk`
--
ALTER TABLE `truk`
  MODIFY `id_truk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_truk`) REFERENCES `truk` (`id_truk`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`);

--
-- Ketidakleluasaan untuk tabel `truk`
--
ALTER TABLE `truk`
  ADD CONSTRAINT `truk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_truk` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
