<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $notabeli = $_POST['notabeli']; 
    $sql = "DELETE FROM tbpembelian WHERE notabeli = '$notabeli'";
    if ($con->query($sql) === TRUE) {
        header("Location: pembelian.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data pembelian
$sql = "SELECT * FROM tbpembelian order by notabeli";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Pembelian</h2>
    <br>
    <a href="insertpembelian.php" class="btn btn-info">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Nota Beli</th>
            <th>Tgl</th>
            <th>ID Pengguna</th>
            <th>ID Pemasok</th>
            <th>Total Beli</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['notabeli']; ?></td>
                <td><?php echo $row['tgl']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['idpemasok']; ?></td>
                <td><?php echo $row['totalbeli']; ?></td>
                <td>
                    <a href="editpembelian.php?id=<?php echo $row['notabeli']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="notabeli" value="<?php echo $row['notabeli']; ?>">
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