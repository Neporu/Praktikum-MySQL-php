<?php require_once './../connect.php';

// Ambil data penjualan
$sql = "SELECT pj.nota, pj.tgltransaksi, COALESCE(m.nama_member, 'Umum') AS nama_member, pg.nama AS nama_pengguna, pj.total 
        FROM tbpenjualan pj
        LEFT JOIN tbmember m ON pj.idmember = m.idmember
        JOIN tbpengguna pg ON pj.id = pg.id
        ORDER BY pj.nota";
$result = $con->query($sql);

?>
<h2>Data Penjualan</h2>
<br>
<a href="#" onclick="replace_modul('form_penjualan')" class="btn btn-info">Tambah Transaksi</a>
<br><br>

<?php if ($result->num_rows > 0) { ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Nota</th>
            <th>Tanggal</th>
            <th>Member</th>
            <th>Kasir</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nota']; ?></td>
            <td><?php echo date('d-m-Y', strtotime($row['tgltransaksi'])); ?></td>
            <td><?php echo $row['nama_member']; ?></td>
            <td><?php echo $row['nama_pengguna']; ?></td>
            <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="viewTransactionDetails('penjualan', <?php echo $row['nota']; ?>)">
                    Detail
                </button>
            </td>
        </tr>
        <?php } ?>
    </table>
<?php } else {
    echo "<div class='alert alert-warning'>Tidak ada data penjualan.</div>";
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