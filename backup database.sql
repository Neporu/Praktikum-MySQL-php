/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - sbd_25sa11a027
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sbd_25sa11a027` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sbd_25sa11a027`;

/*Table structure for table `tbdetailbeli` */

DROP TABLE IF EXISTS `tbdetailbeli`;

CREATE TABLE `tbdetailbeli` (
  `notabeli` varchar(50) DEFAULT NULL,
  `kode` varchar(15) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  KEY `notabeli` (`notabeli`),
  KEY `kode` (`kode`),
  CONSTRAINT `tbdetailbeli_ibfk_1` FOREIGN KEY (`notabeli`) REFERENCES `tbpembelian` (`notabeli`),
  CONSTRAINT `tbdetailbeli_ibfk_2` FOREIGN KEY (`kode`) REFERENCES `tbproduk` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbdetailbeli` */

insert  into `tbdetailbeli`(`notabeli`,`kode`,`jml`,`hargabeli`,`subtotal`) values 
('FD073','F001',70,2500,175000),
('FD089','D003',44,3000,132000),
('C40','C002',47,360000,15700000),
('E04','E017',4,15800000,69000000),
('FD089','D003',3,3000,9000),
('FD089','D003',2,3000,6000),
('FD073','F001',2,2500,5000),
('FD073','F001',5,2500,12500);

/*Table structure for table `tbdetailjual` */

DROP TABLE IF EXISTS `tbdetailjual`;

CREATE TABLE `tbdetailjual` (
  `nota` int(11) DEFAULT NULL,
  `kode` varchar(15) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  UNIQUE KEY `nota` (`nota`),
  KEY `kode` (`kode`),
  CONSTRAINT `tbdetailjual_ibfk_1` FOREIGN KEY (`kode`) REFERENCES `tbproduk` (`kode`),
  CONSTRAINT `tbdetailjual_ibfk_2` FOREIGN KEY (`nota`) REFERENCES `tbpenjualan` (`nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbdetailjual` */

insert  into `tbdetailjual`(`nota`,`kode`,`jml`,`harga`,`subtotal`) values 
(1,'F001',30,2500,36500),
(2,'T005',3,3500,97500),
(3,'E017',1,15800000,15800000),
(4,'C002',1,360000,3600000),
(5,'T005',7,3500,24500);

/*Table structure for table `tbkategori` */

DROP TABLE IF EXISTS `tbkategori`;

CREATE TABLE `tbkategori` (
  `idkategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbkategori` */

insert  into `tbkategori`(`idkategori`,`nama_kategori`) values 
('K01','Foods'),
('K02','Drinks'),
('K03','Snacks'),
('K04','Cloths'),
('K05','Electronics'),
('K06','Tools'),
('K07','Digital Games'),
('K08','Digital Wallet'),
('K09','Digital Camera'),
('K10','Books'),
('K11','Accessories'),
('K13','Medicines');

/*Table structure for table `tbmember` */

DROP TABLE IF EXISTS `tbmember`;

CREATE TABLE `tbmember` (
  `idmember` varchar(15) NOT NULL,
  `nama_member` varchar(70) DEFAULT NULL,
  `alamat` varchar(65) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idmember`),
  UNIQUE KEY `telp` (`telp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbmember` */

insert  into `tbmember`(`idmember`,`nama_member`,`alamat`,`telp`) values 
('M01','Yusuf DP','Purwokerto','089654492597'),
('M02','patrik','Jl.tegal','0896-5549-9999'),
('M03','Yoseph Febrian','Tegal','086223435427'),
('M04','dias Catur putra','Purwokerto','082588924237'),
('M05','Alif MS','Tasikmalaya','089788723972'),
('M06','wawa','Bekasi','0896-5549-0011');

/*Table structure for table `tbpemasok` */

DROP TABLE IF EXISTS `tbpemasok`;

CREATE TABLE `tbpemasok` (
  `idpemasok` varchar(15) NOT NULL,
  `namapemasok` varchar(70) DEFAULT NULL,
  `alamat` varchar(65) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idpemasok`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telp` (`telp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbpemasok` */

insert  into `tbpemasok`(`idpemasok`,`namapemasok`,`alamat`,`email`,`telp`) values 
('CID05','Adidas','Jl.Jepara PT Adidas','adidas@indonesia.com','0896-5549-0271'),
('E03','Samsung','Jl.Semarang PT Samsung','samsung@indonesia.com','0896-5549-8271'),
('f&dID01','Indomie','Jl.Jakarta PT Indomie','indomie@indonesia.com','0892-9912-5220'),
('f&dID09','Sprite','Jl.Jakarta PT Sprite','sprite@indonesia.com','1-431-25');

/*Table structure for table `tbpembelian` */

DROP TABLE IF EXISTS `tbpembelian`;

CREATE TABLE `tbpembelian` (
  `notabeli` varchar(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `idpemasok` varchar(15) DEFAULT NULL,
  `totalbeli` int(11) DEFAULT NULL,
  PRIMARY KEY (`notabeli`),
  KEY `idpemasok` (`idpemasok`),
  KEY `id` (`id`),
  CONSTRAINT `tbpembelian_ibfk_1` FOREIGN KEY (`idpemasok`) REFERENCES `tbpemasok` (`idpemasok`),
  CONSTRAINT `tbpembelian_ibfk_2` FOREIGN KEY (`id`) REFERENCES `tbpengguna` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbpembelian` */

insert  into `tbpembelian`(`notabeli`,`tgl`,`id`,`idpemasok`,`totalbeli`) values 
('C40','0000-00-00',3,'CID05',1570000),
('E04','2025-03-15',4,'E03',69000000),
('FD073','2025-01-27',1,'f&dID01',175000),
('FD089','2025-02-09',2,'f&dID09',132000);

/*Table structure for table `tbpengguna` */

DROP TABLE IF EXISTS `tbpengguna`;

CREATE TABLE `tbpengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `sandi` varchar(20) NOT NULL,
  `jabatan` enum('admin','kasir') DEFAULT NULL,
  `nama` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbpengguna` */

insert  into `tbpengguna`(`id`,`username`,`sandi`,`jabatan`,`nama`) values 
(1,'Neporu','lol90901','admin','Yusuf DP'),
(2,'Alfsa','asinan','admin','Alif MS'),
(3,'ordinary','12345','kasir','Yoseph B'),
(4,'Senator','macbook','kasir','Alif'),
(5,'caputra','menara','kasir','dias catur');

/*Table structure for table `tbpenjualan` */

DROP TABLE IF EXISTS `tbpenjualan`;

CREATE TABLE `tbpenjualan` (
  `nota` int(11) NOT NULL AUTO_INCREMENT,
  `tgltransaksi` date DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `idmember` varchar(15) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`nota`),
  KEY `id` (`id`),
  KEY `idmember` (`idmember`),
  CONSTRAINT `tbpenjualan_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tbpengguna` (`id`),
  CONSTRAINT `tbpenjualan_ibfk_2` FOREIGN KEY (`idmember`) REFERENCES `tbmember` (`idmember`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbpenjualan` */

insert  into `tbpenjualan`(`nota`,`tgltransaksi`,`id`,`idmember`,`total`) values 
(1,'2025-04-16',1,'M01',36500),
(2,'2025-04-29',2,'M03',97500),
(3,'2025-07-09',3,'M04',16299000),
(4,'2025-08-01',4,'M05',347900),
(5,'2025-12-25',5,'m04',95000);

/*Table structure for table `tbproduk` */

DROP TABLE IF EXISTS `tbproduk`;

CREATE TABLE `tbproduk` (
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `idkategori` varchar(6) NOT NULL,
  `harga` int(11) DEFAULT 0,
  `stok` int(11) DEFAULT 0,
  PRIMARY KEY (`kode`),
  KEY `idkategori` (`idkategori`),
  CONSTRAINT `tbproduk_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `tbkategori` (`idkategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbproduk` */

insert  into `tbproduk`(`kode`,`nama`,`idkategori`,`harga`,`stok`) values 
('C002','Adidas','K04',359000,25),
('C003','Snack TNI','K04',39500,5),
('D003','Sprite','K02',3000,25),
('E017','TV OLED 34 inch','K05',15799000,30),
('F001','Mie Goreng Instant','K01',2500,203),
('S019','Cookies','K03',12500,50),
('T005','Gergaji','K06',34999,70);

/* Trigger structure for table `tbdetailbeli` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_upstok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_upstok` AFTER INSERT ON `tbdetailbeli` FOR EACH ROW begin
	update tbproduk set stok=stok+new.jml where kode=new.kode;
end */$$


DELIMITER ;

/* Trigger structure for table `tbmember` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_del` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_del` BEFORE DELETE ON `tbmember` FOR EACH ROW begin
	if old.idmember=old.idmember then
		signal sqlstate '45000'
		set message_text='data member tidak dapat dihapus';
	end if;
end */$$


DELIMITER ;

/* Trigger structure for table `tbpengguna` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_checkin` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_checkin` BEFORE INSERT ON `tbpengguna` FOR EACH ROW begin
	DECLARE itung INT;
	SELECT COUNT(*) INTO itung FROM tbpengguna WHERE sandi = new.sandi;
	IF itung>0 THEN
		signal sqlstate '45000'
		set message_text='insert sandi tidak boleh sama';
	end if;
end */$$


DELIMITER ;

/* Trigger structure for table `tbpengguna` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_checkup` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_checkup` BEFORE UPDATE ON `tbpengguna` FOR EACH ROW begin
	declare itung int;
	select count(*) into itung from tbpengguna where sandi = new.sandi;
	if itung>0 then
		signal sqlstate '45000'
		set message_text='update sandi tidak boleh sama';
	end if;
end */$$


DELIMITER ;

/* Function  structure for function  `cekJmlTransKBeli` */

/*!50003 DROP FUNCTION IF EXISTS `cekJmlTransKBeli` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `cekJmlTransKBeli`(id varchar(10)) RETURNS varchar(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
begin
	declare jml tinyint;
	select count(notabeli) into jml from tbpembelian where idpemasok=id;
	if(jml>0) then
		return concat('Sudah bertansaksi sebanyak ',jml,' kali');
	else
		return concat('Belum pernah bertransaksi');
	end if;
end */$$
DELIMITER ;

/* Function  structure for function  `jmlhless` */

/*!50003 DROP FUNCTION IF EXISTS `jmlhless` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `jmlhless`(stokin int) RETURNS int(11)
BEGIN
	DECLARE jml INT;
	SELECT count(stok) INTO jml FROM tbproduk WHERE stok<stokin;
	RETURN jml;
END */$$
DELIMITER ;

/* Function  structure for function  `tjual` */

/*!50003 DROP FUNCTION IF EXISTS `tjual` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `tjual`(nonota int) RETURNS int(11)
BEGIN
	DECLARE totjual INT;
	SELECT sum(subtotal) INTO totjual FROM tbdetailjual WHERE nota=nonota;
	RETURN totjual;
END */$$
DELIMITER ;

/* Procedure structure for procedure `addmember` */

/*!50003 DROP PROCEDURE IF EXISTS  `addmember` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `addmember`(id varchar(10),nama varchar(50),alamat varchar(100),telp varchar(20))
begin
	insert into tbmember values(id,nama,alamat,telp);
end */$$
DELIMITER ;

/* Procedure structure for procedure `c_jmlPrdkperKategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `c_jmlPrdkperKategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `c_jmlPrdkperKategori`()
BEGIN
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
END */$$
DELIMITER ;

/* Procedure structure for procedure `c_jmlterjual` */

/*!50003 DROP PROCEDURE IF EXISTS  `c_jmlterjual` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `c_jmlterjual`(p_kode varchar(10))
begin
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
end */$$
DELIMITER ;

/* Procedure structure for procedure `c_pelPwt` */

/*!50003 DROP PROCEDURE IF EXISTS  `c_pelPwt` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `c_pelPwt`()
begin
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
end */$$
DELIMITER ;

/* Procedure structure for procedure `genap` */

/*!50003 DROP PROCEDURE IF EXISTS  `genap` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `genap`(batas int)
begin
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
end */$$
DELIMITER ;

/* Procedure structure for procedure `hapuskategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `hapuskategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `hapuskategori`(in id varchar(10))
begin
	delete from tbkategori where idkategori=id;
end */$$
DELIMITER ;

/* Procedure structure for procedure `hapusmember` */

/*!50003 DROP PROCEDURE IF EXISTS  `hapusmember` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusmember`(id varchar(10))
begin
	delete from tbmember where idmember=id;
end */$$
DELIMITER ;

/* Procedure structure for procedure `jmlkategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `jmlkategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `jmlkategori`(out hasil int)
begin
	select count(*) into hasil from tbkategori;
end */$$
DELIMITER ;

/* Procedure structure for procedure `jmlmember` */

/*!50003 DROP PROCEDURE IF EXISTS  `jmlmember` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `jmlmember`(out hasil int)
begin
	select count(*) into hasil from tbmember;
end */$$
DELIMITER ;

/* Procedure structure for procedure `prdk` */

/*!50003 DROP PROCEDURE IF EXISTS  `prdk` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `prdk`()
BEGIN
	SELECT nama,stok,kode FROM tbproduk WHERE stok<10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `tambahkategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambahkategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahkategori`(in id varchar(10), in nama varchar(50))
begin
	insert into tbkategori values(id,nama);
end */$$
DELIMITER ;

/* Procedure structure for procedure `ubahkategori` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubahkategori` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ubahkategori`(in id varchar(10),in nama varchar(50))
begin
	update tbkategori set nama_kategori=nama where idkategori=id;
end */$$
DELIMITER ;

/* Procedure structure for procedure `ubahmember` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubahmember` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `ubahmember`(id varchar(10),nama varchar(50))
begin
	update tbmember set nama_member=nama where idmember=id;
end */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
