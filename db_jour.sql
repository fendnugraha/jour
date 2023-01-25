-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2023 at 05:54 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jour`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `nama` varchar(160) NOT NULL,
  `status` varchar(1) NOT NULL,
  `type` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `kode`, `nama`, `status`, `type`) VALUES
(1, '10100', 'Kas Dan Setara Kas', 'D', 'Assets'),
(2, '10200', 'Bank Rupiah', 'D', 'Assets'),
(3, '10300', 'Deposit', 'D', 'Assets'),
(4, '10400', 'Piutang', 'D', 'Assets'),
(5, '10500', 'Piutang Lainnya', 'D', 'Assets'),
(6, '10600', 'Persediaan', 'D', 'Assets'),
(7, '10700', 'Persediaan Wip', 'D', 'Assets'),
(8, '10800', 'Pembayaran Dimuka', 'D', 'Assets'),
(9, '10900', 'Pajak Dibayar Dimuka', 'D', 'Assets'),
(10, '11100', 'Investasi Jangka Pendek', 'D', 'Assets'),
(11, '11200', 'Investasi Surat Berharga', 'D', 'Assets'),
(12, '11300', 'Investasi Penyertaan Modal', 'D', 'Assets'),
(13, '11400', 'Aset Program Imbalan Pasca Kerja', 'D', 'Assets'),
(14, '11500', 'Aset Tetap - Nilai Perolehan', 'D', 'Assets'),
(15, '11600', 'Aset Tetap - Akumulasi Penyusutan', 'D', 'Assets'),
(16, '11700', 'Aset Tidak Berwujud - Nilai Perolehan', 'D', 'Assets'),
(17, '11800', 'Amortisasi Aset Tidak Berwujud', 'D', 'Assets'),
(18, '11900', 'Aset Lainnya', 'D', 'Assets'),
(19, '20100', 'Utang Usaha Bersih', 'K', 'Liabilities'),
(20, '20200', 'Utang Lancar Lainnya', 'K', 'Liabilities'),
(21, '20300', 'Utang Pajak', 'K', 'Liabilities'),
(22, '20400', 'Utang Bank Dan Non Bank Jangka Pendek', 'K', 'Liabilities'),
(23, '20500', 'Utang Gaji', 'K', 'Liabilities'),
(24, '20600', 'Utang Bank Dan Non Bank Jangka Panjang', 'K', 'Liabilities'),
(25, '20700', 'Utang Imbalan Kerja Jangka Panjang (Psak 24)', 'K', 'Liabilities'),
(26, '30100', 'Ekuitas', 'K', 'Ekuitas'),
(27, '40100', 'Penjualan Barang Dan Jasa', 'K', 'Pendapatan'),
(28, '40200', 'Potongan Penjualan', 'K', 'Pendapatan'),
(29, '40300', 'Retur Penjualan & Penalti', 'K', 'Pendapatan'),
(30, '50100', 'Beban Pemakaian Bahan Baku', 'D', 'Harga Pokok Produksi'),
(31, '50200', 'Beban Penyedia Jasa Subkontrak', 'D', 'Harga Pokok Produksi'),
(32, '60101', 'Beban Gaji Langsung', 'D', 'Biaya'),
(33, '60102', 'Beban Upah Tenaga Kontrak Langsung (Pulsa)', 'D', 'Biaya'),
(34, '60103', 'Beban Konsultan, Tenaga Ahli Dan Agen Pulsa', 'D', 'Biaya'),
(35, '60104', 'Beban Gaji Overhead Pulsa', 'D', 'Biaya'),
(36, '60105', 'Beban Bahan Pendukung Usaha', 'D', 'Biaya'),
(37, '60106', 'Beban Sewa Alat & Pengiriman', 'D', 'Biaya'),
(38, '60107', 'Beban Perjalanan Dinas', 'D', 'Biaya'),
(39, '60108', 'Beban Keselamatan Kerja', 'D', 'Biaya'),
(40, '60109', 'Beban Pemeliharaan Dan Perbaikan Aset Tetap', 'D', 'Biaya'),
(41, '60110', 'Beban Lain-Lain', 'D', 'Biaya'),
(42, '60111', 'Pengurangan Pembelian', 'D', 'Biaya'),
(43, '60112', 'Beban Board Of Director (Bod)', 'D', 'Biaya'),
(44, '60113', 'Beban Lain-Lain Corporate', 'D', 'Biaya');

-- --------------------------------------------------------

--
-- Table structure for table `account_trace`
--

CREATE TABLE `account_trace` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `invoice` varchar(160) NOT NULL,
  `description` varchar(320) NOT NULL,
  `debt_code` varchar(60) NOT NULL,
  `cred_code` varchar(60) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rvpy` varchar(60) DEFAULT NULL,
  `pay_stats` int(11) DEFAULT NULL,
  `pay_nth` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_trace`
--

INSERT INTO `account_trace` (`id`, `waktu`, `invoice`, `description`, `debt_code`, `cred_code`, `jumlah`, `status`, `rvpy`, `pay_stats`, `pay_nth`, `user_id`) VALUES
(5, '2023-01-21 22:33:00', 'JR.BK.210123.7.0000001', 'Uang Makan fend 3hari', '60101-002', '10100-001', 70000, 1, NULL, NULL, NULL, 7),
(6, '2023-01-21 22:34:00', 'JR.BK.210123.7.0000002', 'Upah harian narayan sangkar', '60101-001', '10100-001', 65000, 1, NULL, NULL, NULL, 7),
(7, '2023-01-25 22:24:00', 'JR.BK.250123.7.0000003', 'Harian dadan', '60101-001', '10100-001', 150000, 1, NULL, NULL, NULL, 7),
(8, '2023-01-25 23:26:00', 'RV.BK.250123.7.7.0000001', 'Pinjam untuk foya foya', '10400-002', '10100-001', 300000, 1, 'Receivable', 0, 0, 7),
(9, '2023-01-25 23:36:00', 'RV.BK.250123.7.7.0000002', 'Pinjam dulu bayar esok lusa', '10400-002', '10100-001', 200000, 1, 'Receivable', 0, 0, 7),
(10, '2023-01-25 23:51:00', 'RV.BK.250123.7.8.0000001', 'Bon dulu sementara', '10400-001', '10200-001', 3000000, 1, 'Receivable', 0, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `acc_coa`
--

CREATE TABLE `acc_coa` (
  `id` int(11) NOT NULL,
  `acc_code` varchar(60) NOT NULL,
  `acc_name` varchar(160) NOT NULL,
  `main_acc` varchar(160) NOT NULL,
  `status` varchar(1) NOT NULL,
  `type` varchar(160) NOT NULL,
  `st_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acc_coa`
--

INSERT INTO `acc_coa` (`id`, `acc_code`, `acc_name`, `main_acc`, `status`, `type`, `st_balance`) VALUES
(1, '10100-001', 'Kas Kecil', 'Kas Dan Setara Kas', 'D', 'Assets', 50000),
(2, '10100-002', 'Kas Besar', 'Kas Dan Setara Kas', 'D', 'Assets', 500000),
(3, '10200-001', 'Bank BCA an GEMILANG SOLUSI', 'Bank Rupiah', 'D', 'Assets', 13000000),
(4, '10400-001', 'Piutang Usaha', 'Piutang', 'D', 'Assets', 0),
(5, '20100-001', 'Hutang Usaha', 'Utang Usaha Bersih', 'K', 'Liabilities', 0),
(6, '10100-003', 'Kas Kecil Cabang II', 'Kas Dan Setara Kas', 'D', 'Assets', 200000),
(7, '30100-001', 'Modal', 'Ekuitas', 'K', 'Ekuitas', 0),
(8, '40100-001', 'Penjualan Barang', 'Penjualan Barang Dan Jasa', 'K', 'Pendapatan', 0),
(9, '50100-001', 'HPP', 'Beban Pemakaian Bahan Baku', 'D', 'Harga Pokok Produksi', 0),
(10, '60101-001', 'Beban Gaji Karyawan Langsung', 'Beban Gaji Langsung', 'D', 'Biaya', 0),
(11, '30100-002', 'Laba Rugi', 'Ekuitas', 'K', 'Ekuitas', 0),
(12, '60101-002', 'Uang Makan Karyawan', 'Beban Gaji Langsung', 'D', 'Biaya', 0),
(13, '10400-002', 'Piutang Karyawan', 'Piutang', 'D', 'Assets', 0),
(14, '60105-001', 'Beban Listrik', 'Beban Bahan Pendukung Usaha', 'D', 'Biaya', 0),
(15, '60105-002', 'Beban Jasa Internet', 'Beban Bahan Pendukung Usaha', 'D', 'Biaya', 0),
(16, '60113-001', 'Beban Sponsorship dan Sumbangan', 'Beban Lain-Lain Corporate', 'D', 'Biaya', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cashflow`
--

CREATE TABLE `cashflow` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `invoice` varchar(30) NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deskripsi` varchar(160) NOT NULL,
  `date_modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashflow`
--

INSERT INTO `cashflow` (`id`, `waktu`, `invoice`, `masuk`, `keluar`, `status`, `deskripsi`, `date_modified`, `user_id`) VALUES
(17, '2023-01-14 15:24:00', 'CO.BK.140123.7.0000001', 0, 30000, 1, 'sampah', 1673684657, 7),
(19, '2023-01-18 22:44:00', 'CO.BK.180123.7.0000001', 0, 15000, 1, 'UM fend', 1674056691, 7),
(20, '2023-01-21 22:01:00', 'CO.BK.210123.7.0000001', 0, 150000, 1, 'Pembelian stok barang', 1674313295, 7);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL,
  `keterangan` varchar(160) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `nama`, `type`, `keterangan`) VALUES
(7, 'DOA IBU Inc', 'Supplier', 'Dagang Pulsa Dan Kuota           '),
(8, 'DURA CO', 'Konsumen', 'Premium Clothing Line and Apparel                            ');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(160) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `beli` int(11) NOT NULL,
  `jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_modified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `kode`, `nama`, `cat_id`, `beli`, `jual`, `stok`, `is_active`, `date_modified`) VALUES
(1, 'KP0001', 'Kopi Hitam Gillus Mix', 1, 1500, 3500, 100, 1, 1674313295);

-- --------------------------------------------------------

--
-- Table structure for table `product_cat`
--

CREATE TABLE `product_cat` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `prefix` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_cat`
--

INSERT INTO `product_cat` (`id`, `category`, `prefix`) VALUES
(1, 'Kopi Sobek', 'KP');

-- --------------------------------------------------------

--
-- Table structure for table `product_trace`
--

CREATE TABLE `product_trace` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `invoice` varchar(30) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchases` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_trace`
--

INSERT INTO `product_trace` (`id`, `waktu`, `invoice`, `contact_id`, `product_id`, `purchases`, `sales`, `price`, `cost`, `status`, `date_created`, `user_id`) VALUES
(1, '2023-01-21 22:01:00', 'CO.BK.210123.7.0000001', 7, 1, 100, 0, 1500, 0, 1, 1674313295, 7);

-- --------------------------------------------------------

--
-- Table structure for table `receivable_tb`
--

CREATE TABLE `receivable_tb` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `invoice` varchar(60) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `description` varchar(160) NOT NULL,
  `bill_amount` int(11) NOT NULL,
  `pay_amount` int(11) NOT NULL,
  `pay_stats` int(11) NOT NULL,
  `pay_nth` int(11) NOT NULL,
  `rv_type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receivable_tb`
--

INSERT INTO `receivable_tb` (`id`, `waktu`, `invoice`, `contact_id`, `description`, `bill_amount`, `pay_amount`, `pay_stats`, `pay_nth`, `rv_type`) VALUES
(1, '2023-01-25 23:26:00', 'RV.BK.250123.7.7.0000001', 7, 'Pinjam untuk foya foya', 300000, 0, 0, 0, '10100-001'),
(3, '2023-01-25 23:36:00', 'RV.BK.250123.7.7.0000002', 7, 'Pinjam dulu bayar esok lusa', 200000, 0, 0, 0, '10100-001'),
(4, '2023-01-25 23:51:00', 'RV.BK.250123.7.8.0000001', 8, 'Bon dulu sementara', 3000000, 0, 0, 0, '10200-001');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(15) NOT NULL,
  `slogan` varchar(30) DEFAULT NULL,
  `address` varchar(160) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `kas_awal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `brand_name`, `slogan`, `address`, `phone`, `kas_awal`) VALUES
(1, 'DURA.CO APPAREL', 'Jaya Jaya Jaya', 'Ciputat, Andir, Baleendah, Bandung, Jawa Barat, 40375', '085186080992', 2000000);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Aktif'),
(2, 'Void');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(160) NOT NULL,
  `password` varchar(360) NOT NULL,
  `role` int(11) NOT NULL,
  `date_reg` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `fullname`, `password`, `role`, `date_reg`, `last_login`, `status`) VALUES
(7, 'administrator', 'Administrator', '$2y$10$8A9am7VSx50MGCvnVi.Luegdet2ZJyenak/igCaH7B6kWxEP1Nq3e', 1, 1669868304, 1674660249, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Kasir'),
(3, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_trace`
--
ALTER TABLE `account_trace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_coa`
--
ALTER TABLE `acc_coa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashflow`
--
ALTER TABLE `cashflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `product_cat`
--
ALTER TABLE `product_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_trace`
--
ALTER TABLE `product_trace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receivable_tb`
--
ALTER TABLE `receivable_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `account_trace`
--
ALTER TABLE `account_trace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `acc_coa`
--
ALTER TABLE `acc_coa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cashflow`
--
ALTER TABLE `cashflow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_cat`
--
ALTER TABLE `product_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_trace`
--
ALTER TABLE `product_trace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receivable_tb`
--
ALTER TABLE `receivable_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
