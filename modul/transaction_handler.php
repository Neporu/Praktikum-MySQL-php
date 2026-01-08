<?php
require_once './../connect.php';

// Proses Tambah Penjualan
if (isset($_POST['addsale'])) {
    $con->begin_transaction();
    try {
        $tgl = $_POST['tgltransaksi'];
        $idmember = !empty($_POST['idmember']) ? "'".$_POST['idmember']."'" : "NULL";
        $iduser = $_POST['id'];
        $total = 0;

        // Hitung total dulu
        for ($i = 0; $i < count($_POST['kode']); $i++) {
            $kode = $_POST['kode'][$i];
            $jml = (int)$_POST['jml'][$i];
            $product_res = $con->query("SELECT harga, stok FROM tbproduk WHERE kode = '$kode'");
            $product = $product_res->fetch_assoc();
            $harga = (int)$product['harga'];
            if($jml > $product['stok']){
                throw new Exception("Stok produk ".$kode." tidak mencukupi.");
            }
            $total += $harga * $jml;
        }

        $sql_penjualan = "INSERT INTO tbpenjualan (tgltransaksi, id, idmember, total) VALUES ('$tgl', $iduser, $idmember, $total)";
        if (!$con->query($sql_penjualan)) {
            throw new Exception("Gagal menyimpan data penjualan: " . $con->error);
        }
        $nota = $con->insert_id;

        for ($i = 0; $i < count($_POST['kode']); $i++) {
            $kode = $_POST['kode'][$i];
            $jml = (int)$_POST['jml'][$i];
            $product_res = $con->query("SELECT harga FROM tbproduk WHERE kode = '$kode'");
            $harga = (int)$product_res->fetch_assoc()['harga'];
            $subtotal = $harga * $jml;

            $sql_detail = "INSERT INTO tbdetailjual (nota, kode, jml, harga, subtotal) VALUES ($nota, '$kode', $jml, $harga, $subtotal)";
            if (!$con->query($sql_detail)) {
                throw new Exception("Gagal menyimpan detail penjualan: " . $con->error);
            }
            
            // Update stok
            $sql_update_stok = "UPDATE tbproduk SET stok = stok - $jml WHERE kode = '$kode'";
            if(!$con->query($sql_update_stok)){
                throw new Exception("Gagal update stok produk: " . $con->error);
            }
        }

        $con->commit();
        echo "success";
    } catch (Exception $e) {
        $con->rollback();
        echo $e->getMessage();
    }
    exit();
}

// Proses Tambah Pembelian
if (isset($_POST['addpurchase'])) {
    $con->begin_transaction();
    try {
        $notabeli = $_POST['notabeli'];
        $tgl = $_POST['tgl'];
        $idpemasok = $_POST['idpemasok'];
        $iduser = $_POST['id'];
        $totalbeli = 0;

        // Hitung total dulu
        for ($i = 0; $i < count($_POST['kode']); $i++) {
            $jml = (int)$_POST['jml'][$i];
            $hargabeli = (int)$_POST['hargabeli'][$i];
            $totalbeli += $hargabeli * $jml;
        }

        $sql_pembelian = "INSERT INTO tbpembelian (notabeli, tgl, id, idpemasok, totalbeli) VALUES ('$notabeli', '$tgl', $iduser, '$idpemasok', $totalbeli)";
        if (!$con->query($sql_pembelian)) {
            throw new Exception("Gagal menyimpan data pembelian: " . $con->error);
        }

        for ($i = 0; $i < count($_POST['kode']); $i++) {
            $kode = $_POST['kode'][$i];
            $jml = (int)$_POST['jml'][$i];
            $hargabeli = (int)$_POST['hargabeli'][$i];
            $subtotal = $hargabeli * $jml;

            $sql_detail = "INSERT INTO tbdetailbeli (notabeli, kode, jml, hargabeli, subtotal) VALUES ('$notabeli', '$kode', $jml, $hargabeli, $subtotal)";
            if (!$con->query($sql_detail)) {
                throw new Exception("Gagal menyimpan detail pembelian: " . $con->error);
            }
        }

        $con->commit();
        echo "success";
    } catch (Exception $e) {
        $con->rollback();
        echo $e->getMessage();
    }
    exit();
}


// Ambil Detail Transaksi
if (isset($_GET['get_details'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];
    
    if ($type == 'penjualan') {
        $sql = "SELECT p.nama, dj.jml, dj.harga, dj.subtotal 
                FROM tbdetailjual dj 
                JOIN tbproduk p ON dj.kode = p.kode 
                WHERE dj.nota = $id";
    } else { // pembelian
        $sql = "SELECT p.nama, db.jml, db.hargabeli, db.subtotal 
                FROM tbdetailbeli db 
                JOIN tbproduk p ON db.kode = p.kode 
                WHERE db.notabeli = '$id'";
    }
    
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $output = '<table class="table table-bordered">';
        $output .= '<tr><th>Produk</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr>';
        while ($row = $result->fetch_assoc()) {
            $output .= '<tr>';
            $output .= '<td>' . $row['nama'] . '</td>';
            $output .= '<td>' . $row['jml'] . '</td>';
            $output .= '<td>' . number_format($type == 'penjualan' ? $row['harga'] : $row['hargabeli']) . '</td>';
            $output .= '<td>' . number_format($row['subtotal']) . '</td>';
            $output .= '</tr>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'Tidak ada detail untuk transaksi ini.';
    }
    exit();
}
?>