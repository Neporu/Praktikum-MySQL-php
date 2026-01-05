<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $idpemasok = $_POST['idpemasok']; 
    $sql = "DELETE FROM tbpemasok WHERE idpemasok = '$idpemasok'";
    if ($con->query($sql) === TRUE) {
        header("Location: pemasok.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data pemasok
$sql = "SELECT * FROM tbpemasok order by idpemasok";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Pemasok</h2>
    <br>
    <a href="insertpemasok.php" class="btn btn-info">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Id Pemasok</th>
            <th>Nama Pemasok</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Telp</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['idpemasok']; ?></td>
                <td><?php echo $row['namapemasok']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['telp']; ?></td>
                <td>
                    <a href="editpemasok.php?id=<?php echo $row['idpemasok']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="idpemasok" value="<?php echo $row['idpemasok']; ?>">
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