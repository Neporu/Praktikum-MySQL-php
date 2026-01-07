# -- praktikum 3
CREATE DATABASE sbd_25sa11a027;
CREATE TABLE tbpengguna (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR (30) UNIQUE  NOT NULL,
	sandi VARCHAR (20) NOT NULL,
	jabatan ENUM ('admin','kasir'),
	nama VARCHAR (40)
);
CREATE TABLE tbkategori (
	idkategori VARCHAR(6) NOT NULL PRIMARY KEY,
	nama_kategori VARCHAR(100) NOT NULL
);
CREATE TABLE tbproduk (
	kode VARCHAR(15) NOT NULL PRIMARY KEY,
	nama VARCHAR(100) NOT NULL,
	idkategori VARCHAR(6) NOT NULL,
	harga INT DEFAULT 0,
	stok INT DEFAULT 0,
	FOREIGN KEY (idkategori) REFERENCES tbkategori (idkategori)
);
CREATE TABLE tbmember (
	idmember VARCHAR(15) NOT NULL PRIMARY KEY,
	nama_member VARCHAR (70),
	alamat VARCHAR (65),
	telp VARCHAR (20) UNIQUE
);
CREATE TABLE tbpenjualan (
	nota INT AUTO_INCREMENT PRIMARY KEY,
	tgltransaksi DATE,
	id INT,
	idmember VARCHAR(15),
	total INT,
	FOREIGN KEY (id) REFERENCES tbpengguna(id),
	FOREIGN KEY (idmember) REFERENCES tbmember (idmember)
);
CREATE TABLE tbdetailjual (
	nota INT(11) UNIQUE,
	kode VARCHAR(15),
	jml INT(11),
	harga INT(11),
	subtotal INT(11),
	FOREIGN KEY (kode) REFERENCES tbproduk (kode),
	FOREIGN KEY (nota) REFERENCES tbpenjualan (nota)
);
CREATE TABLE tbpemasok (
	idpemasok VARCHAR(15) NOT NULL PRIMARY KEY,
	namapemasok VARCHAR(70),
	kontak VARCHAR(60),
	alamat VARCHAR(65),
	email VARCHAR(70)UNIQUE,
	telp VARCHAR(20)UNIQUE
);
CREATE TABLE tbpembelian (
	notabeli VARCHAR(50) NOT NULL PRIMARY KEY,
	tgl DATE,
	id INT(11),
	idpemasok VARCHAR(15),
	totalbeli INT(11),
	FOREIGN KEY (idpemasok) REFERENCES tbpemasok(idpemasok)
);
CREATE TABLE tbdetailbeli (
	notabeli VARCHAR(50),
	kode VARCHAR(15),
	jml INT(11),
	hargabeli INT(11),
	subtotal INT(11),
	FOREIGN KEY (notabeli) REFERENCES tbpembelian(notabeli),
	FOREIGN KEY (kode) REFERENCES tbproduk(kode)
);
ALTER TABLE tbproduk CHANGE harga harga INT DEFAULT 0;
ALTER TABLE tbpemasok DROP COLUMN kontak;
ALTER TABLE tbpembelian ADD FOREIGN KEY (id) REFERENCES tbpengguna(id);
-- DROP DATABASE sbd_pk3_25sa11a027

# -- praktikum 4
INSERT INTO tbpengguna (username, sandi, jabatan, nama) VALUES
('Neporu','lol90901','admin','Yusuf DP'),
('Alfsa','asinan','admin','Alif MS'),
('Patrick','tegal','kasir','Yoseph B'),
('Senator','macbook','kasir','Alif');
INSERT INTO tbmember (idmember, nama_member, alamat, telp) VALUES
('M01','Yusuf DP','Purwokerto','089654492597'),
('M03','Yoseph B','Tegal','086223435427'),
('M04','Catur','Purwokerto','082588924237'),
('M05','Alif MS','Tasikmalaya','089788723972');
INSERT INTO tbkategori (idkategori, nama_kategori) VALUES
('K01','Foods'),
('K02','Drinks'),
('K03','Snacks'),
('K04','Clothes'),
('K05','Electronics'),
('K06','Tools');
INSERT INTO tbproduk (kode, nama, idkategori, harga, stok) VALUES
('F001','Mie Goreng Instant','K01', 2500, 200),
('D003','Sprite','K02', 3000, 30),
('S019','Cookies','K03', 12500, 50),
('C002','Adidas','K04', 359000, 25),
('E017','TV OLED 34 inch','K05', 15799000, 30),
('T005','Gergaji','K06', 34999, 70);

SELECT * FROM tbpengguna;
SELECT * FROM tbmember;
INSERT INTO tbpenjualan (tgltransaksi, id, idmember, total) VALUES
('2025-04-16', 1, 'M01', 36500),
('2025-04-29', 2, 'M03', 97500),
('2025-07-09', 3, 'M04', 16299000),
('2025-08-01', 4, 'M05', 347900);

SELECT * FROM tbpenjualan;
INSERT INTO tbdetailjual (nota, kode, jml, harga, subtotal) VALUES
( 1, 'F001', 30, 2500, 36500),
( 2, 'T005', 3, 3500, 97500),
( 3, 'E017', 1, 15800000, 15800000),
( 4, 'C002', 1, 360000, 3600000);

INSERT INTO tbpemasok (idpemasok, namapemasok, alamat, email, telp) VALUES
('f&dID01', 'Indomie', 'Jl.Jakarta PT Indomie', 'indomie@indonesia.com', '1-123-92'),
('f&dID09', 'Sprite', 'Jl.Jakarta PT Sprite', 'sprite@indonesia.com', '1-431-25'),
('CID05', 'Adidas', 'Jl.Jepara PT Adidas', 'adidas@indonesia.com', '8-223-71'),
('E03', 'Samsung', 'Jl.Semarang PT Samsung', 'samsung@indonesia.com', '3-578-32');
INSERT INTO tbpembelian (notabeli, tgl, id, idpemasok, totalbeli) VALUES
('FD073', '2025-01-27', 1,'f&dID01', 175000),
('FD089', '2025-02-09', 2,'f&dID09', 132000),
('C40', '2025-02-30', 3,'CID05', 1570000),
('E04', '2025-03-15', 4,'E03', 69000000);
INSERT INTO tbdetailbeli (notabeli, kode, jml, hargabeli, subtotal) VALUES
('FD073', 'F001', 70, 2500, 175000 ),
('FD089', 'D003', 44, 3000, 132000),
('C40', 'C002', 47, 360000, 15700000),
('E04', 'E017', 4, 15800000, 69000000);

UPDATE tbpengguna SET username='Ian Von' WHERE nama='Yoseph B';
DELETE FROM tbkategori WHERE idkategori='K07';
SELECT * FROM tbproduk;

SELECT * FROM tbproduk WHERE stok<=30;
SELECT * FROM tbproduk WHERE harga BETWEEN 10000 AND 50000;
SELECT * FROM tbmember WHERE nama_member NOT LIKE 'Y%';
SELECT * FROM tbmember WHERE idmember IN ('M01','M05');
SELECT * FROM tbproduk ORDER BY harga DESC;

# -- praktikum 5 "DCL - grant & revoke"
SELECT USER, HOST, PASSWORD FROM USER;
DROP USER 'Yusuf'@'localhost';
DROP USER 'Supervisor'@'localhost';
-- tugas 1-2
CREATE USER 'Yusuf'@'localhost' IDENTIFIED BY '25sa11a027';
GRANT SELECT ON sbd_25sa11a027.tbproduk TO 'Yusuf'@'localhost';
GRANT SELECT ON sbd_25sa11a027.tbpenjualan TO 'Yusuf'@'localhost';
GRANT UPDATE(stok) ON sbd_25sa11a027.tbproduk TO 'Yusuf'@'localhost';
GRANT INSERT ON sbd_25sa11a027.tbpenjualan TO 'Yusuf'@'localhost';
GRANT INSERT ON sbd_25sa11a027.tbpembelian TO 'Yusuf'@'localhost';
-- tugas 3
CREATE USER 'Supervisor'@'localhost';
GRANT ALL ON sbd_25sa11a027.* TO 'Supervisor'@'localhost';
SHOW GRANTS FOR 'Yusuf'@'localhost';
SHOW GRANTS FOR 'Supervisor'@'localhost';
-- tugas 4
SELECT MAX(harga) 'Produk Termahal' FROM tbproduk;
SELECT MIN(harga) 'Produk Termurah' FROM tbproduk;
-- tugas 5
SELECT idkategori, AVG(harga) 'Harga Rata-rata' FROM tbproduk GROUP BY idkategori;
-- tugas 6
SELECT idpemasok, SUM(totalbeli) 'Total Pembelian' FROM tbpembelian GROUP BY idpemasok ORDER BY totalbeli DESC;
-- tugas 7
SELECT tgltransaksi, SUM(total) 'Total Penjualan' FROM tbpenjualan GROUP BY tgltransaksi;
-- tugas 8
SELECT COUNT(*) 'Transaksi/Member' FROM tbpenjualan;
-- tugas 9
SELECT idpemasok, SUM(totalbeli) 'Total Pembelian' FROM tbpembelian GROUP BY idpemasok;
-- tugas 10
SELECT kode, SUM(jml) FROM tbdetailjual GROUP BY kode HAVING SUM(jml) > 5;

# -- Praktikum 6 'Join Table'
-- SELECT p.kode, p.nama, k.nama_kategori FROM tbproduk p CROSS JOIN tbkategori k
-- SELECT p.kode, p.nama, k.nama_kategori FROM tbproduk p JOIN tbkategori k ON p.idkategori = k.idkategori
-- SELECT p.kode, p.nama, k.nama_kategori FROM tbproduk p LEFT JOIN tbkategori k ON p.idkategori = k.idkategori
-- SELECT p.kode, p.nama, k.nama_kategori FROM tbproduk p RIGHT JOIN tbkategori k ON p.idkategori = k.idkategori
-- SELECT dj.kode, p.nama, dj.jml, dj.harga, dj.subtotal FROM tbdetailjual dj JOIN tbproduk p ON dj.kode = p.kode ORDER BY kode
# -- tugas 1
SELECT p.nota, p.tgltransaksi, p.idmember, m.nama_member
FROM tbpenjualan p
LEFT JOIN tbmember m ON p.idmember = m.idmember
# -- tugas 2
SELECT dj.nota, dj.kode, p.nama 
FROM tbproduk p 
RIGHT JOIN tbdetailjual dj ON p.kode = dj.kode
# -- tugas 3
SELECT p.nota, p.tgltransaksi, m.nama_member, u.nama, p.total 
FROM tbpenjualan p
JOIN tbmember m ON p.idmember = m.idmember
JOIN tbpengguna u ON p.id = u.id
# -- tugas 4
SELECT pb.notabeli, pem.namapemasok, p.nama, db.jml, db.subtotal 
FROM tbpemasok pem
JOIN tbpembelian pb ON pem.idpemasok = pb.idpemasok
JOIN tbdetailbeli db ON pb.notabeli = db.notabeli
JOIN tbproduk p ON db.kode = p.kode

# Praktikum 8
SELECT nama_member, LEFT(nama_member,5),RIGHT(nama_member,5) FROM tbmember;
SELECT * FROM tbpenjualan;
SELECT tgltransaksi,DATEDIFF(NOW(),tgltransaksi) FROM tbpenjualan WHERE nota=3;
SELECT tgltransaksi,MONTHNAME(tgltransaksi) FROM tbpenjualan;
# -- tugas 1
DELIMITER !!
CREATE OR REPLACE PROCEDURE addmember(id VARCHAR(10),nama VARCHAR(50),alamat VARCHAR(100),telp VARCHAR(20))
BEGIN
	INSERT INTO tbmember VALUES(id,nama,alamat,telp);
END!!
CALL addmember('m06','Bagus Kusuma','Ajibarang','08965549390');
# -- tugas 2
DELIMITER //
CREATE OR REPLACE PROCEDURE ubahmember(id VARCHAR(10),nama VARCHAR(50))
BEGIN
	UPDATE tbmember SET nama_member=nama WHERE idmember=id;
END//
CALL ubahmember('m06','M. Bagus Kusuma');
# -- tugas 3
DELIMITER @@
CREATE OR REPLACE PROCEDURE hapusmember(id VARCHAR(10))
BEGIN
	DELETE FROM tbmember WHERE idmember=id;
END@@
CALL hapusmember('m06');
# -- tugas 4
DELIMITER ]]
CREATE OR REPLACE PROCEDURE jmlmember(OUT hasil INT)
BEGIN
	SELECT COUNT(*) INTO hasil FROM tbmember;
END]]
CALL jmlmember(@jml);
SELECT @jml 'jml member';
# -- tugas 5
INSERT INTO tbproduk VALUES('C003','Snack TNI','K04',39500, 5);
DELIMITER ==
CREATE OR REPLACE PROCEDURE prdk()
BEGIN
	SELECT nama,stok,kode FROM tbproduk WHERE stok<10;
END==
CALL prdk;
# -- tugas 6
SELECT * FROM tbdetailjual;
DELIMITER --
CREATE OR REPLACE FUNCTION tjual(nonota INT)
RETURNS INT
BEGIN
	DECLARE totjual INT;
	SELECT SUM(subtotal) INTO totjual FROM tbdetailjual WHERE nota=nonota;
	RETURN totjual;
END--
SELECT tjual(1);
# -- tugas 7
DELIMITER --
CREATE OR REPLACE FUNCTION jmlhless(stokin INT)
RETURNS INT
BEGIN
	DECLARE jml INT;
	SELECT COUNT(stok) INTO jml FROM tbproduk WHERE stok<stokin;
	RETURN jml;
END--
SELECT jmlhless(10);

# Praktikum 9
# -- tugas 1
# disini hanya ada kategori Clothes(baju) yaitu K04
SELECT kode, nama, idkategori, harga, 
	IF(idkategori='K04',harga*0.1,'0') 'diskon' 
FROM tbproduk;
# -- tugas 2
SELECT kode, SUM(jml), 
	IF(jml<=5,'Rendah',IF(jml>20,'Tinggi','Sedang')) 'level_penjulan'
FROM tbdetailjual GROUP BY kode
# -- tugas 3
DELIMITER //
CREATE OR REPLACE FUNCTION cekJmlTransKBeli(id VARCHAR(10))
RETURNS VARCHAR(50)
BEGIN
	DECLARE jml TINYINT;
	SELECT COUNT(notabeli) INTO jml FROM tbpembelian WHERE idpemasok=id;
	IF(jml>0) THEN
		RETURN CONCAT('Sudah bertansaksi sebanyak ',jml,' kali');
	ELSE
		RETURN CONCAT('Belum pernah bertransaksi');
	END IF;
END//
SELECT cekJmlTransKBeli('CID05')
# -- tugas 4
DELIMITER //
CREATE OR REPLACE PROCEDURE genap(batas INT)
BEGIN
	DECLARE i INT;
	DECLARE hasil VARCHAR(1000)DEFAULT'';
	SET i = 1;
	WHILE i<batas DO
		IF MOD(i,2)=0 THEN
		SET hasil = CONCAT(hasil,i,' ');
		END IF;
		SET i = i+1;
	END WHILE;
	SELECT hasil;
END//
CALL genap(25)

# Praktikum 10
# tugas 1
DELIMITER ,,
CREATE OR REPLACE TRIGGER tr_upstok
AFTER INSERT ON tbdetailbeli
FOR EACH ROW BEGIN
	UPDATE tbproduk SET stok=stok+new.jml WHERE kode=new.kode;
END,,
SELECT * FROM tbproduk;
SELECT * FROM tbdetailbeli;
INSERT INTO tbdetailbeli (notabeli,kode,jml,hargabeli,subtotal) VALUES
('FD073','F001',5,2500,5*2500);
# tugas 2
DELIMITER ,,
CREATE OR REPLACE TRIGGER tr_checkin
BEFORE INSERT ON tbpengguna
FOR EACH ROW BEGIN
	DECLARE itung INT;
	SELECT COUNT(*) INTO itung FROM tbpengguna WHERE sandi = new.sandi;
	IF itung>0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT='insert sandi tidak boleh sama';
	END IF;
END,,
INSERT INTO tbpengguna (id,username,sandi,jabatan,nama) VALUES
(5,'caputra','sangkala','kasir','dias catur');
SELECT * FROM tbpengguna;
# tugas 3
DELIMITER ,,
CREATE OR REPLACE TRIGGER tr_checkup
BEFORE UPDATE ON tbpengguna
FOR EACH ROW BEGIN
	DECLARE itung INT;
	SELECT COUNT(*) INTO itung FROM tbpengguna WHERE sandi = new.sandi;
	IF itung>0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT='update sandi tidak boleh sama';
	END IF;
END,,
UPDATE tbpengguna SET sandi='ACEH' WHERE id=5;
SELECT * FROM tbpengguna;
# tugas 4
DELIMITER ,,
CREATE OR REPLACE TRIGGER tr_del
BEFORE DELETE ON tbmember
FOR EACH ROW BEGIN
	IF old.idmember=old.idmember THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT='data member tidak dapat dihapus';
	END IF;
END,,
DELETE FROM tbmember WHERE idmember='M04';
SELECT * FROM tbmember;

# Praktikum 11
#-tugas 1
SELECT * FROM tbmember
DELIMITER //
CREATE OR REPLACE PROCEDURE c_pelPwt()
BEGIN
	DECLARE nama VARCHAR(15);
	DECLARE rampung INT DEFAULT 0;
	DECLARE cur CURSOR FOR 
	SELECT nama_member FROM tbmember WHERE alamat='Purwokerto';
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET rampung=1;
	CREATE TEMPORARY TABLE IF NOT EXISTS tmp_nama (namapel VARCHAR(100));
	TRUNCATE tmp_nama;
	OPEN cur;
	cekloop: LOOP
		FETCH cur INTO nama;
		IF rampung=1 THEN 
			LEAVE cekloop;
		END IF;
		INSERT INTO tmp_nama VALUES (nama);
	END LOOP;
	SELECT namapel 'Daftar pelanggan yang berdomisili di Purwokerto' FROM tmp_nama;
	CLOSE cur;
END//
CALL c_pelPwt();
#-tugas 2
SELECT * FROM tbproduk;
SELECT * FROM tbkategori;
DELIMITER ==
CREATE OR REPLACE PROCEDURE c_jmlPrdkperKategori()
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
END==
CALL c_jmlPrdkperKategori();
#-tugas 3
SELECT * FROM tbdetailjual;
SELECT * FROM tbpenjualan;
SELECT * FROM tbpengguna;
SELECT * FROM tbmember;
INSERT INTO tbpenjualan VALUES (5,'2025-12-25',5,'m04',95000);
INSERT INTO tbdetailjual VALUES (5,'T005',7,3500,7*3500);
DELIMITER ==
CREATE OR REPLACE PROCEDURE c_jmlterjual(p_kode VARCHAR(10))
BEGIN
	DECLARE vkode VARCHAR(10);
	DECLARE vjml INT;
	DECLARE done INT DEFAULT 0;
	DECLARE cur CURSOR FOR
	SELECT kode, SUM(jml) FROM tbdetailjual WHERE kode=p_kode;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=1;
	CREATE TEMPORARY TABLE IF NOT EXISTS tmp_jmlterjual(kode VARCHAR(10), jml INT);
	TRUNCATE tmp_jmlterjual;
	OPEN cur;
	ulang: LOOP
		FETCH cur INTO vkode, vjml;
		IF done=1 THEN
			LEAVE ulang;
		END IF;
		INSERT INTO tmp_jmlterjual VALUES (vkode, vjml);
	END LOOP;
	CLOSE cur;
	IF (SELECT SUM(jml) FROM tmp_jmlterjual) > 0 THEN
		SELECT * FROM tmp_jmlterjual;
	ELSE
		SELECT 'Produk belum pernah terjual' AS message;
	END IF;
END==
CALL c_jmlterjual('g005');