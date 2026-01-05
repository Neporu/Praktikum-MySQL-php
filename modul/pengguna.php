<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $id = $_POST['id']; 
    $sql = "DELETE FROM tbpengguna WHERE id = '$id'";
    if ($con->query($sql) === TRUE) {
        header("Location: pengguna.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data pengguna
$sql = "SELECT * FROM tbpengguna order by id";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Pengguna</h2>
    <br>
    <a href="insertpengguna.php" class="btn btn-info">Tambah Data</a>
    <br><br>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Id pengguna</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Nama pengguna</th>
            <th colspan="2">Aksi</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['jabatan']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td>
                    <a href="editpengguna.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="delete" value="Hapus" class="btn btn-danger btn-sm">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php
} else {
    echo "<br><br><div class='alert alert-warning'>Tidak ada data pengguna.</div>";
}?>