<?php 
require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $idmember = $_POST['idmember']; 
    $sql = "DELETE FROM tbmember WHERE idmember = '$idmember'";
    if ($con->query($sql) === TRUE) {
        header("Location: member.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }
}
// Ambil data member
$sql = "SELECT * FROM tbmember order by idmember";
$result = $con->query($sql);
if ($result->num_rows > 0) {
?>
    <h2>Data Member</h2>
    <br>
    <a href="insertmember.php" class="btn btn-info">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Id Member</th>
            <th>Nama Member</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['idmember']; ?></td>
                <td><?php echo $row['nama_member']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['telp']; ?></td>
                <td>
                    <a href="editmember.php?id=<?php echo $row['idmember']; ?>" class="btn btn-info btn-sm">Ubah</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="idmember" value="<?php echo $row['idmember']; ?>">
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