<?php  require_once './../connect.php';

// Proses Delete
if (isset($_POST['delete'])) {
    $pk = $_POST['id']; 
    
    $check_sql = "SELECT COUNT(*) as count FROM tbpenjualan WHERE idmember = '$pk'";
    $check_result = $con->query($check_sql);
    if ($check_result->fetch_assoc()['count'] > 0) {
        echo "Gagal menghapus: Member ini memiliki riwayat transaksi.";
        exit();
    }

    $sql = "DELETE FROM tbmember WHERE idmember = '$pk'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal menghapus data: " . $con->error;
    }
    exit();
}

// Proses Insert
if (isset($_POST['addnew'])) {
    $new1 = $_POST['idmember'];
    $new2 = $_POST['nama_member'];
    $new3 = $_POST['alamat'];
    $new4 = $_POST['telp'];
    
    if (empty($new1) || empty($new2) || empty($new3) || empty($new4)) {
        echo "Semua field harus diisi!";
        exit();
    }
    
    $check_id_sql = "SELECT idmember FROM tbmember WHERE idmember = '$new1'";
    if ($con->query($check_id_sql)->num_rows > 0) {
        echo "Gagal: ID Member '$new1' sudah ada.";
        exit();
    }

    $check_telp_sql = "SELECT telp FROM tbmember WHERE telp = '$new4'";
    if ($con->query($check_telp_sql)->num_rows > 0) {
        echo "Gagal: No. Telepon '$new4' sudah digunakan.";
        exit();
    }

    $sql = "INSERT INTO tbmember (idmember, nama_member, alamat, telp) 
            VALUES ('$new1', '$new2', '$new3', '$new4')";

    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal menambahkan data: " . $con->error;
    }
    exit();
}

// Proses Update
if (isset($_POST['update'])) {
    $up1 = $_POST['idmember'];
    $up2 = $_POST['nama_member'];
    $up3 = $_POST['alamat'];
    $up4 = $_POST['telp'];

    if (empty($up1) || empty($up2) || empty($up3) || empty($up4)) {
        echo "Semua field harus diisi.";
        exit();
    }

    $check_telp_sql = "SELECT telp FROM tbmember WHERE telp = '$up4' AND idmember != '$up1'";
    if ($con->query($check_telp_sql)->num_rows > 0) {
        echo "Gagal: No. Telepon '$up4' sudah digunakan oleh member lain.";
        exit();
    }

    $sql = "UPDATE tbmember SET nama_member = '$up2', alamat = '$up3', telp = '$up4' WHERE idmember = '$up1'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal mengubah data: " . $con->error;
    }
    exit();
}

// Ambil data
$sql = "SELECT * FROM tbmember ORDER BY idmember";
$result = $con->query($sql);
if ($result->num_rows > 0) {?>
    <h2>Data Member</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal('modalTambah')">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID Member</th>
            <th>Nama Member</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
            $attr1 = $row['idmember'];
            $attr2 = $row['nama_member'];
            $attr3 = $row['alamat'];
            $attr4 = $row['telp'];
        ?>
        <tr>
            <td><?php echo $attr1 ?></td>
            <td><?php echo $attr2 ?></td>
            <td><?php echo $attr3 ?></td>
            <td><?php echo $attr4 ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="editData('modalEdit','<?php echo $attr1?>', '<?php echo $attr2?>', '<?php echo $attr3?>', '<?php echo $attr4?>')">
                    Ubah
                </button>
                <form class="formHapus ajax-form" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $attr1 ?>">
                    <input type="submit" name="delete" value="Hapus" class="btn btn-danger btn-sm">
                </form> 
            </td>
        </tr>
        <?php } ?>
    </table>
<?php } else { echo "<br><br><div class='alert alert-warning'>Tidak ada data Member.</div>"; } ?>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Member</h3>
            <form id="formTambah" class="ajax-form" method="POST">
                <label>ID Member</label>
                <input type="text" name="idmember" class="form-control" required><br>
                <label>Nama Member</label>
                <input type="text" name="nama_member" class="form-control" required><br>
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required><br>
                <label>Telepon</label>
                <input type="text" name="telp" class="form-control" required><br>
                <button type="submit" name="addnew" class="btn btn-success">Tambah</button>
                <a href="#" class="btn btn-info" onclick="closeModal('modalTambah')">Batal</a>
            </form> 
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Member</h3>
            <form id="formUpdate" class="ajax-form" method="POST">
                <label>ID Member</label>
                <input type="text" id="edit-1" name="idmember" class="form-control" readonly><br>
                <label>Nama Member</label>
                <input type="text" id="edit-2" name="nama_member" class="form-control" required><br>
                <label>Alamat</label>
                <input type="text" id="edit-3" name="alamat" class="form-control" required><br>
                <label>Telepon</label>
                <input type="text" id="edit-4" name="telp" class="form-control" required><br>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="#" class="btn btn-info" onclick="closeModal('modalEdit')">Batal</a>
            </form>
        </div>
    </div>

    <!-- Modal Sukses -->
    <div id="success" class="modal">
        <div class="modal-content text-center">
            <h1 style="color: #A8DF8E;"><i class="glyphicon glyphicon-ok"></i>&nbsp;<br>Sukses</h1>
        </div>
    </div>