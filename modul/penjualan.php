<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $nota = $_POST['nota']; 
    $sql = "DELETE FROM tbpenjualan WHERE nota = '$nota'";
    if ($con->query($sql) === TRUE) {
        header("Location: penjualan.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data penjualan
$sql = "SELECT * FROM tbpenjualan order by nota";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Penjualan</h2>
    <br>
    <a href="insertpenjualan.php" class="btn btn-info">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Nota</th>
            <th>Tgl Transaksi</th>
            <th>ID Pengguna</th>
            <th>ID Member</th>
            <th>Total</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nota']; ?></td>
                <td><?php echo $row['tgltransaksi']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['idmember']; ?></td>
                <td><?php echo $row['total']; ?></td>
                <td>
                    <a href="editpenjualan.php?id=<?php echo $row['nota']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="nota" value="<?php echo $row['nota']; ?>">
                        <input type="submit" name="delete" value="Hapus" class="btn btn-danger btn-sm">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php
} else {
    echo "<br><br><div class='alert alert-warning'>Tidak ada data Kategori.</div>";
}?>