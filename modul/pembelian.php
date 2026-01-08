<?php require_once './../connect.php';

// Ambil data pembelian
$sql = "SELECT pb.notabeli, pb.tgl, p.namapemasok, pg.nama AS nama_pengguna, pb.totalbeli 
        FROM tbpembelian pb
        JOIN tbpemasok p ON pb.idpemasok = p.idpemasok
        JOIN tbpengguna pg ON pb.id = pg.id
        ORDER BY pb.tgl DESC, pb.notabeli";
$result = $con->query($sql);

?>
<h2>Data Pembelian</h2>
<br>
<a href="#" onclick="replace_modul('form_pembelian')" class="btn btn-info">Tambah Transaksi</a>
<br><br>

<?php if ($result->num_rows > 0) { ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Nota Beli</th>
            <th>Tanggal</th>
            <th>Pemasok</th>
            <th>Petugas</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['notabeli']; ?></td>
            <td><?php echo date('d-m-Y', strtotime($row['tgl'])); ?></td>
            <td><?php echo $row['namapemasok']; ?></td>
            <td><?php echo $row['nama_pengguna']; ?></td>
            <td>Rp <?php echo number_format($row['totalbeli'], 0, ',', '.'); ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="viewTransactionDetails('pembelian', '<?php echo $row['notabeli']; ?>')">
                    Detail
                </button>
            </td>
        </tr>
        <?php } ?>
    </table>
<?php } else {
    echo "<div class='alert alert-warning'>Tidak ada data pembelian.</div>";
} ?>

<!-- Modal Detail Transaksi -->
<div id="modalDetail" class="modal">
    <div class="modal-content">
        <h3>Detail Transaksi</h3>
        <div id="detailContent"></div>
        <br>
        <a href="#" class="btn btn-info" onclick="closeModal('modalDetail')">Tutup</a>
    </div>
</div>