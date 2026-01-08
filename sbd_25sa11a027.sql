-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 03:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbd_25sa11a027`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addmember` (`id` VARCHAR(10), `nama` VARCHAR(50), `alamat` VARCHAR(100), `telp` VARCHAR(20))   begin
	insert into tbmember values(id,nama,alamat,telp);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `c_jmlPrdkperKategori` ()   BEGIN
	DECLARE vID VARCHAR(5);
	DECLARE vNamakategori VARCHAR(50);
	DECLARE vJml INT;
	DECLARE done INT DEFAULT 0;
	DECLARE cur CURSOR FOR 
	SELECT idkategori, nama, COUNT(*) FROM tbproduk GROUP BY idkategori;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=1;
	CREATE TEMPORARY TABLE IF NOT EXISTS tmp_perkategori(id VARCHAR(5),namakategori VARCHAR(50),jml INT);
	TRUNCATE tmp_perkategori;
	OPEN cur;
	ulang: LOOP
		FETCH cur INTO vID, vNamakategori, vJml;
		IF done=1 THEN
			LEAVE ulang;
		END IF;
		INSERT INTO tmp_perkategori VALUES (vID,vNamakategori,vJml);
	END LOOP;
	CLOSE cur;
	SELECT * FROM tmp_perkategori;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `c_jmlterjual` (`p_kode` VARCHAR(10))   begin
	declare vkode varchar(10);
	declare vjml int;
	declare done int default 0;
	declare cur cursor for
	select kode, sum(jml) from tbdetailjual where kode=p_kode;
	declare continue handler for not found set done=1;
	create temporary table if not exists tmp_jmlterjual(kode varchar(10), jml int);
	truncate tmp_jmlterjual;
	open cur;
	ulang: loop
		fetch cur into vkode, vjml;
		if done=1 then
			leave ulang;
		end if;
		insert into tmp_jmlterjual values (vkode, vjml);
	end loop;
	close cur;
	if (select sum(jml) from tmp_jmlterjual) > 0 then
		select * from tmp_jmlterjual;
	else
		select 'Produk belum pernah terjual' as message;
	end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `c_pelPwt` ()   begin
	declare nama varchar(15);
	DECLARE rampung INT DEFAULT 0;
	declare cur cursor for 
	select nama_member from tbmember where alamat='Purwokerto';
	declare continue handler for not found set rampung=1;
	create temporary table if not exists tmp_nama (namapel varchar(100));
	truncate tmp_nama;
	open cur;
	cekloop: loop
		fetch cur into nama;
		if rampung=1 then 
			leave cekloop;
		end if;
		insert into tmp_nama values (nama);
	end loop;
	SELECT namapel 'Daftar pelanggan yang berdomisili di Purwokerto' from tmp_nama;
	close cur;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genap` (`batas` INT)   begin
	declare i int;
	declare hasil varchar(1000)default'';
	set i = 1;
	while i<batas do
		if mod(i,2)=0 then
		set hasil = concat(hasil,i,' ');
		end if;
		set i = i+1;
	end while;
	select hasil;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapuskategori` (IN `id` VARCHAR(10))   begin
	delete from tbkategori where idkategori=id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusmember` (`id` VARCHAR(10))   begin
	delete from tbmember where idmember=id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `jmlkategori` (OUT `hasil` INT)   begin
	select count(*) into hasil from tbkategori;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `jmlmember` (OUT `hasil` INT)   begin
	select count(*) into hasil from tbmember;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prdk` ()   BEGIN
	SELECT nama,stok,kode FROM tbproduk WHERE stok<10;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahkategori` (IN `id` VARCHAR(10), IN `nama` VARCHAR(50))   begin
	insert into tbkategori values(id,nama);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ubahkategori` (IN `id` VARCHAR(10), IN `nama` VARCHAR(50))   begin
	update tbkategori set nama_kategori=nama where idkategori=id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ubahmember` (`id` VARCHAR(10), `nama` VARCHAR(50))   begin
	update tbmember set nama_member=nama where idmember=id;
end$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `cekJmlTransKBeli` (`id` VARCHAR(10)) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
	declare jml tinyint;
	select count(notabeli) into jml from tbpembelian where idpemasok=id;
	if(jml>0) then
		return concat('Sudah bertansaksi sebanyak ',jml,' kali');
	else
		return concat('Belum pernah bertransaksi');
	end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jmlhless` (`stokin` INT) RETURNS INT(11)  BEGIN
	DECLARE jml INT;
	SELECT count(stok) INTO jml FROM tbproduk WHERE stok<stokin;
	RETURN jml;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tjual` (`nonota` INT) RETURNS INT(11)  BEGIN
	DECLARE totjual INT;
	SELECT sum(subtotal) INTO totjual FROM tbdetailjual WHERE nota=nonota;
	RETURN totjual;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbdetailbeli`
--

CREATE TABLE `tbdetailbeli` (
  `notabeli` varchar(50) DEFAULT NULL,
  `kode` varchar(15) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbdetailbeli`
--

INSERT INTO `tbdetailbeli` (`notabeli`, `kode`, `jml`, `hargabeli`, `subtotal`) VALUES
('FD073', 'F001', 70, 2500, 175000),
('FD089', 'D003', 44, 3000, 132000),
('C40', 'C002', 47, 360000, 15700000),
('E04', 'E017', 4, 15800000, 69000000),
('FD089', 'D003', 3, 3000, 9000),
('FD089', 'D003', 2, 3000, 6000),
('FD073', 'F001', 2, 2500, 5000),
('FD073', 'F001', 5, 2500, 12500);

--
-- Triggers `tbdetailbeli`
--
DELIMITER $$
CREATE TRIGGER `tr_upstok` AFTER INSERT ON `tbdetailbeli` FOR EACH ROW begin
	update tbproduk set stok=stok+new.jml where kode=new.kode;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbdetailjual`
--

CREATE TABLE `tbdetailjual` (
  `nota` int(11) DEFAULT NULL,
  `kode` varchar(15) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbdetailjual`
--

INSERT INTO `tbdetailjual` (`nota`, `kode`, `jml`, `harga`, `subtotal`) VALUES
(1, 'F001', 30, 2500, 36500),
(2, 'T005', 3, 3500, 97500),
(3, 'E017', 1, 15800000, 15800000),
(4, 'C002', 1, 360000, 3600000),
(5, 'T005', 7, 3500, 24500);

-- --------------------------------------------------------

--
-- Table structure for table `tbkategori`
--

CREATE TABLE `tbkategori` (
  `idkategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbkategori`
--

INSERT INTO `tbkategori` (`idkategori`, `nama_kategori`) VALUES
('K01', 'Foods'),
('K02', 'Drinks'),
('K03', 'Snacks'),
('K04', 'Cloths'),
('K05', 'Electronics'),
('K06', 'Tools'),
('K07', 'Digital Games'),
('K08', 'Digital Wallet'),
('K09', 'Digital Camera'),
('K10', 'Books'),
('K11', 'Accessories'),
('K13', 'Medicines');

-- --------------------------------------------------------

--
-- Table structure for table `tbmember`
--

CREATE TABLE `tbmember` (
  `idmember` varchar(15) NOT NULL,
  `nama_member` varchar(70) DEFAULT NULL,
  `alamat` varchar(65) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbmember`
--

INSERT INTO `tbmember` (`idmember`, `nama_member`, `alamat`, `telp`) VALUES
('M01', 'Yusuf DP', 'Purwokerto', '089654492597'),
('M02', 'patrik', 'Jl.tegal', '0896-5549-9999'),
('M03', 'Yoseph Febrian', 'Tegal', '086223435427'),
('M04', 'dias Catur putra', 'Purwokerto', '082588924237'),
('M05', 'Alif MS', 'Tasikmalaya', '089788723972'),
('M06', 'wawa', 'Bekasi', '0896-5549-0011');

--
-- Triggers `tbmember`
--
DELIMITER $$
CREATE TRIGGER `tr_del` BEFORE DELETE ON `tbmember` FOR EACH ROW begin
	if old.idmember=old.idmember then
		signal sqlstate '45000'
		set message_text='data member tidak dapat dihapus';
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbpemasok`
--

CREATE TABLE `tbpemasok` (
  `idpemasok` varchar(15) NOT NULL,
  `namapemasok` varchar(70) DEFAULT NULL,
  `alamat` varchar(65) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpemasok`
--

INSERT INTO `tbpemasok` (`idpemasok`, `namapemasok`, `alamat`, `email`, `telp`) VALUES
('CID05', 'Adidas', 'Jl.Jepara PT Adidas', 'adidas@indonesia.com', '0896-5549-0271'),
('E03', 'Samsung', 'Jl.Semarang PT Samsung', 'samsung@indonesia.com', '0896-5549-8271'),
('f&dID01', 'Indomie', 'Jl.Jakarta PT Indomie', 'indomie@indonesia.com', '0892-9912-5220'),
('f&dID09', 'Sprite', 'Jl.Jakarta PT Sprite', 'sprite@indonesia.com', '1-431-25');

-- --------------------------------------------------------

--
-- Table structure for table `tbpembelian`
--

CREATE TABLE `tbpembelian` (
  `notabeli` varchar(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `idpemasok` varchar(15) DEFAULT NULL,
  `totalbeli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpembelian`
--

INSERT INTO `tbpembelian` (`notabeli`, `tgl`, `id`, `idpemasok`, `totalbeli`) VALUES
('C40', '0000-00-00', 3, 'CID05', 1570000),
('E04', '2025-03-15', 4, 'E03', 69000000),
('FD073', '2025-01-27', 1, 'f&dID01', 175000),
('FD089', '2025-02-09', 2, 'f&dID09', 132000);

-- --------------------------------------------------------

--
-- Table structure for table `tbpengguna`
--

CREATE TABLE `tbpengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `sandi` varchar(20) NOT NULL,
  `jabatan` enum('admin','kasir') DEFAULT NULL,
  `nama` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpengguna`
--

INSERT INTO `tbpengguna` (`id`, `username`, `sandi`, `jabatan`, `nama`) VALUES
(1, 'Neporu', 'lol90901', 'admin', 'Yusuf DP'),
(2, 'Alfsa', 'asinan', 'admin', 'Alif MS'),
(3, 'ordinary', '12345', 'kasir', 'Yoseph B'),
(4, 'Senator', 'macbook', 'kasir', 'Alif'),
(5, 'caputra', 'menara', 'kasir', 'dias catur');

--
-- Triggers `tbpengguna`
--
DELIMITER $$
CREATE TRIGGER `tr_checkin` BEFORE INSERT ON `tbpengguna` FOR EACH ROW begin
	DECLARE itung INT;
	SELECT COUNT(*) INTO itung FROM tbpengguna WHERE sandi = new.sandi;
	IF itung>0 THEN
		signal sqlstate '45000'
		set message_text='insert sandi tidak boleh sama';
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_checkup` BEFORE UPDATE ON `tbpengguna` FOR EACH ROW begin
	declare itung int;
	select count(*) into itung from tbpengguna where sandi = new.sandi;
	if itung>0 then
		signal sqlstate '45000'
		set message_text='update sandi tidak boleh sama';
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbpenjualan`
--

CREATE TABLE `tbpenjualan` (
  `nota` int(11) NOT NULL,
  `tgltransaksi` date DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `idmember` varchar(15) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpenjualan`
--

INSERT INTO `tbpenjualan` (`nota`, `tgltransaksi`, `id`, `idmember`, `total`) VALUES
(1, '2025-04-16', 1, 'M01', 36500),
(2, '2025-04-29', 2, 'M03', 97500),
(3, '2025-07-09', 3, 'M04', 16299000),
(4, '2025-08-01', 4, 'M05', 347900),
(5, '2025-12-25', 5, 'm04', 95000);

-- --------------------------------------------------------

--
-- Table structure for table `tbproduk`
--

CREATE TABLE `tbproduk` (
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `idkategori` varchar(6) NOT NULL,
  `harga` int(11) DEFAULT 0,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbproduk`
--

INSERT INTO `tbproduk` (`kode`, `nama`, `idkategori`, `harga`, `stok`) VALUES
('C002', 'Adidas', 'K04', 359000, 25),
('C003', 'Snack TNI', 'K04', 39500, 5),
('D003', 'Sprite', 'K02', 3000, 25),
('E017', 'TV OLED 34 inch', 'K05', 15799000, 30),
('F001', 'Mie Goreng Instant', 'K01', 2500, 203),
('S019', 'Cookies', 'K03', 12500, 50),
('T005', 'Gergaji', 'K06', 34999, 70);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbdetailbeli`
--
ALTER TABLE `tbdetailbeli`
  ADD KEY `notabeli` (`notabeli`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `tbdetailjual`
--
ALTER TABLE `tbdetailjual`
  ADD UNIQUE KEY `nota` (`nota`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `tbkategori`
--
ALTER TABLE `tbkategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `tbmember`
--
ALTER TABLE `tbmember`
  ADD PRIMARY KEY (`idmember`),
  ADD UNIQUE KEY `telp` (`telp`);

--
-- Indexes for table `tbpemasok`
--
ALTER TABLE `tbpemasok`
  ADD PRIMARY KEY (`idpemasok`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telp` (`telp`);

--
-- Indexes for table `tbpembelian`
--
ALTER TABLE `tbpembelian`
  ADD PRIMARY KEY (`notabeli`),
  ADD KEY `idpemasok` (`idpemasok`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbpengguna`
--
ALTER TABLE `tbpengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbpenjualan`
--
ALTER TABLE `tbpenjualan`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `id` (`id`),
  ADD KEY `idmember` (`idmember`);

--
-- Indexes for table `tbproduk`
--
ALTER TABLE `tbproduk`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `idkategori` (`idkategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbpengguna`
--
ALTER TABLE `tbpengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbpenjualan`
--
ALTER TABLE `tbpenjualan`
  MODIFY `nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbdetailbeli`
--
ALTER TABLE `tbdetailbeli`
  ADD CONSTRAINT `tbdetailbeli_ibfk_1` FOREIGN KEY (`notabeli`) REFERENCES `tbpembelian` (`notabeli`),
  ADD CONSTRAINT `tbdetailbeli_ibfk_2` FOREIGN KEY (`kode`) REFERENCES `tbproduk` (`kode`);

--
-- Constraints for table `tbdetailjual`
--
ALTER TABLE `tbdetailjual`
  ADD CONSTRAINT `tbdetailjual_ibfk_1` FOREIGN KEY (`kode`) REFERENCES `tbproduk` (`kode`),
  ADD CONSTRAINT `tbdetailjual_ibfk_2` FOREIGN KEY (`nota`) REFERENCES `tbpenjualan` (`nota`);

--
-- Constraints for table `tbpembelian`
--
ALTER TABLE `tbpembelian`
  ADD CONSTRAINT `tbpembelian_ibfk_1` FOREIGN KEY (`idpemasok`) REFERENCES `tbpemasok` (`idpemasok`),
  ADD CONSTRAINT `tbpembelian_ibfk_2` FOREIGN KEY (`id`) REFERENCES `tbpengguna` (`id`);

--
-- Constraints for table `tbpenjualan`
--
ALTER TABLE `tbpenjualan`
  ADD CONSTRAINT `tbpenjualan_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tbpengguna` (`id`),
  ADD CONSTRAINT `tbpenjualan_ibfk_2` FOREIGN KEY (`idmember`) REFERENCES `tbmember` (`idmember`);

--
-- Constraints for table `tbproduk`
--
ALTER TABLE `tbproduk`
  ADD CONSTRAINT `tbproduk_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `tbkategori` (`idkategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
