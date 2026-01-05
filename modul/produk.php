<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $kode = $_POST['kode']; 
    $sql = "DELETE FROM tbproduk WHERE kode = '$kode'";
    if ($con->query($sql) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data produk
$sql = "SELECT * FROM tbproduk order by kode";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Produk</h2>
    <br>
    <a href="insertproduk.php" class="btn btn-info">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>kode</th>
            <th>Nama Produk</th>
            <th>ID Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['kode']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['idkategori']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="editproduk.php?id=<?php echo $row['kode']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="kode" value="<?php echo $row['kode']; ?>">
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