-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Waktu pembuatan: 16 Jun 2025 pada 08.21
-- Versi server: 10.6.19-MariaDB
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
-- Database: `if0_39238712_db_telur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `Id_Pembayaran` int(11) NOT NULL,
  `Subtotal_Produk` varchar(20) DEFAULT NULL,
  `Total_Pembayaran` varchar(30) DEFAULT NULL,
  `Id_Pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`Id_Pembayaran`, `Subtotal_Produk`, `Total_Pembayaran`, `Id_Pengguna`) VALUES
(1, NULL, '28000', 5),
(2, NULL, '12000', 5),
(3, NULL, '12000', 5),
(4, NULL, '28000', 3),
(5, NULL, '44000', 6),
(6, NULL, '28000', 3),
(7, NULL, '28000', 3),
(8, NULL, '28000', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `Id_Produk` int(11) NOT NULL,
  `Nama_Produk` varchar(20) DEFAULT NULL,
  `Harga_Produk` varchar(20) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`Id_Produk`, `Nama_Produk`, `Harga_Produk`, `gambar`) VALUES
(1, 'Telur Ayam Kampung', '18000', 'TelurKampung.png'),
(2, 'Telur Ayam Negeri', '16000', 'TelurNegeri.png'),
(3, 'Telur Ayam Organik', '16000', 'TelurOrganik.png'),
(4, 'Telur Ayam Omega', '20000', 'TelurOmega.png'),
(5, 'Telur Bebek', '20000', 'TelurBebek.png'),
(6, 'Telur Puyuh', '15000', 'TelurPuyuh.png'),
(7, 'Telur Angsa', '30000', 'TelurAngsa.png'),
(8, 'Telur Ayam Mutiara', '25000', 'TelurAyamMutiara.png'),
(15, 'awa1', '10000', '1b2c5e22d413abf4c6df0b1f442cb4b7.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `Id_Membeli` int(11) NOT NULL,
  `Id_Pengguna` int(11) NOT NULL,
  `Id_Produk` int(11) NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Id_Pembayaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`Id_Membeli`, `Id_Pengguna`, `Id_Produk`, `Jumlah`, `Id_Pembayaran`) VALUES
(10, 3, 3, 1, 4),
(11, 5, 3, 1, 1),
(12, 6, 2, 2, 5),
(13, 3, 3, 1, 6),
(14, 3, 3, 1, 7),
(16, 3, 2, 1, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_admin`
--

CREATE TABLE `t_admin` (
  `id_admin` int(15) NOT NULL,
  `nama_admin` varchar(40) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email_Admin` varchar(255) DEFAULT NULL,
  `NoHP` varchar(15) DEFAULT NULL,
  `Alamat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `nama_admin`, `Password`, `Email_Admin`, `NoHP`, `Alamat`) VALUES
(1, 'Pandu', '$2a$12$/jZSNYTqYUl1EmlRzW2ZD.5SKEXbioxkQhQswucHYEeORctbODdXe', 'pandusagalang2@gmail.com', '081328803520', 'Desa Tulung Kecamatan Kawedanan Kabupaten Magetan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pengguna`
--

CREATE TABLE `t_pengguna` (
  `Id_Pengguna` int(11) NOT NULL,
  `Nama_pengguna` varchar(45) DEFAULT NULL,
  `Email_Pengguna` varchar(45) DEFAULT NULL,
  `NoTelp_Pengguna` varchar(20) DEFAULT NULL,
  `Alamat_Pengguna` varchar(35) DEFAULT NULL,
  `JenisKelamin` varchar(20) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `token_ganti` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pengguna`
--

INSERT INTO `t_pengguna` (`Id_Pengguna`, `Nama_pengguna`, `Email_Pengguna`, `NoTelp_Pengguna`, `Alamat_Pengguna`, `JenisKelamin`, `Password`, `token_ganti`) VALUES
(2, 'amel', 'amel@gmail.com', '081328803025', 'Jl Serayu, Kota Madiun', 'Perempuan', '$2a$12$fVg7qBpBAy27jzs61XeuEuBQNPU2Z0tN0EYybb0LI/JbNqCLApB8.', 0),
(3, 'Pandu Putrad', 'pandu@gmail.com', '081328803520', 'Kota Madiun, Provinsi Jawa Timur, I', 'Laki-Laki', '$2y$10$8ZjiqzGZRxaGzpBTZAlxluI7x6zr3.xyEBLmmq6Q1fuCdfoDa5BIW', 198705),
(4, 'bimo', 'bimo@gmail.com', '081328804025', 'Jl Serayu, Kota Madiun', 'Laki-Laki', '$2a$12$JWBpfYSm6gVUuGp5uJftQutO.88biZfDweS0HAb4ebcVLRuSNdWk6', 0),
(5, 'awa', 'awa@gmail.com', '081328802040', 'desa banjarejo magetan', 'Laki-Laki', '$2y$10$7mUwQcl/ki.GDVtFYU1/kOupr1B4IIBR.Ybx4r3zD0tKp/Hj7kaa6', 0),
(6, 'Amba', 'amba@gmail.com', '082335436100', 'Ngawi', 'Laki-Laki', '$2y$10$hvI1LbejxvPyUa1aVUTDgueE5gpujnSn2asPb7XyQH.V69IUaNdo.', 0),
(7, 'adi', 'adi@gmail.com', '081328803520', 'Kota Madiun, Provinsi Jawa Timur, I', 'Laki-Laki', '$2y$10$XqfOvjIfUzSa8nqU9xBi7us0Kc8gG/yJlfneq6NrdUdqn6c2JNC86', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`Id_Pembayaran`),
  ADD KEY `fk_pembayaran_pengguna` (`Id_Pengguna`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`Id_Produk`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`Id_Membeli`),
  ADD KEY `Id_Pengguna` (`Id_Pengguna`),
  ADD KEY `Id_Produk` (`Id_Produk`),
  ADD KEY `Id_Pembayaran` (`Id_Pembayaran`);

--
-- Indeks untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `t_pengguna`
--
ALTER TABLE `t_pengguna`
  ADD PRIMARY KEY (`Id_Pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `Id_Pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `Id_Produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `Id_Membeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `id_admin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `t_pengguna`
--
ALTER TABLE `t_pengguna`
  MODIFY `Id_Pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pengguna` FOREIGN KEY (`Id_Pengguna`) REFERENCES `t_pengguna` (`Id_Pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`Id_Pengguna`) REFERENCES `t_pengguna` (`Id_Pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`Id_Produk`) REFERENCES `produk` (`Id_Produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`Id_Pembayaran`) REFERENCES `pembayaran` (`Id_Pembayaran`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
