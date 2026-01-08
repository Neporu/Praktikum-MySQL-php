<?php  require_once './../connect.php';

// Proses Delete
if (isset($_POST['delete'])) {
    $pk = $_POST['id']; 
    
    $check_sql = "SELECT COUNT(*) as count FROM tbpembelian WHERE idpemasok = '$pk'";
    $check_result = $con->query($check_sql);
    if ($check_result->fetch_assoc()['count'] > 0) {
        echo "Gagal menghapus: Pemasok ini memiliki riwayat transaksi pembelian.";
        exit();
    }

    $sql = "DELETE FROM tbpemasok WHERE idpemasok = '$pk'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal menghapus data: " . $con->error;
    }
    exit();
}

// Proses Insert
if (isset($_POST['addnew'])) {
    $new1 = $_POST['idpemasok'];
    $new2 = $_POST['namapemasok'];
    $new3 = $_POST['alamat'];
    $new4 = $_POST['email'];
    $new5 = $_POST['telp'];
    
    if (empty($new1) || empty($new2) || empty($new3) || empty($new4) || empty($new5)) {
        echo "Semua field harus diisi!";
        exit();
    }
    
    $check_id_sql = "SELECT idpemasok FROM tbpemasok WHERE idpemasok = '$new1'";
    if ($con->query($check_id_sql)->num_rows > 0) {
        echo "Gagal: ID Pemasok '$new1' sudah ada.";
        exit();
    }

    $check_email_sql = "SELECT email FROM tbpemasok WHERE email = '$new4'";
    if ($con->query($check_email_sql)->num_rows > 0) {
        echo "Gagal: Email '$new4' sudah digunakan.";
        exit();
    }

    $check_telp_sql = "SELECT telp FROM tbpemasok WHERE telp = '$new5'";
    if ($con->query($check_telp_sql)->num_rows > 0) {
        echo "Gagal: No. Telepon '$new5' sudah digunakan.";
        exit();
    }

    $sql = "INSERT INTO tbpemasok (idpemasok, namapemasok, alamat, email, telp) 
            VALUES ('$new1', '$new2', '$new3', '$new4', '$new5')";

    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal menambahkan data: " . $con->error;
    }
    exit();
}

// Proses Update
if (isset($_POST['update'])) {
    $up1 = $_POST['idpemasok'];
    $up2 = $_POST['namapemasok'];
    $up3 = $_POST['alamat'];
    $up4 = $_POST['email'];
    $up5 = $_POST['telp'];

    if (empty($up1) || empty($up2) || empty($up3) || empty($up4) || empty($up5)) {
        echo "Semua field harus diisi.";
        exit();
    }

    $check_email_sql = "SELECT email FROM tbpemasok WHERE email = '$up4' AND idpemasok != '$up1'";
    if ($con->query($check_email_sql)->num_rows > 0) {
        echo "Gagal: Email '$up4' sudah digunakan oleh pemasok lain.";
        exit();
    }

    $check_telp_sql = "SELECT telp FROM tbpemasok WHERE telp = '$up5' AND idpemasok != '$up1'";
    if ($con->query($check_telp_sql)->num_rows > 0) {
        echo "Gagal: No. Telepon '$up5' sudah digunakan oleh pemasok lain.";
        exit();
    }

    $sql = "UPDATE tbpemasok SET namapemasok = '$up2', alamat = '$up3', email = '$up4', telp = '$up5' WHERE idpemasok = '$up1'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal mengubah data: " . $con->error;
    }
    exit();
}

// Ambil data
$sql = "SELECT * FROM tbpemasok ORDER BY idpemasok";
$result = $con->query($sql);
if ($result->num_rows > 0) {?>
    <h2>Data Pemasok</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal('modalTambah')">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID Pemasok</th>
            <th>Nama Pemasok</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
            $attr1 = $row['idpemasok'];
            $attr2 = $row['namapemasok'];
            $attr3 = $row['alamat'];
            $attr4 = $row['email'];
            $attr5 = $row['telp'];
        ?>
        <tr>
            <td><?php echo $attr1 ?></td>
            <td><?php echo $attr2 ?></td>
            <td><?php echo $attr3 ?></td>
            <td><?php echo $attr4 ?></td>
            <td><?php echo $attr5 ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="editData('modalEdit','<?php echo $attr1?>', '<?php echo $attr2?>', '<?php echo $attr3?>', '<?php echo $attr4?>', '<?php echo $attr5?>')">
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
<?php } else { echo "<br><br><div class='alert alert-warning'>Tidak ada data Pemasok.</div>"; } ?>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Pemasok</h3>
            <form id="formTambah" class="ajax-form" method="POST">
                <label>ID Pemasok</label>
                <input type="text" name="idpemasok" class="form-control" required><br>
                <label>Nama Pemasok</label>
                <input type="text" name="namapemasok" class="form-control" required><br>
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required><br>
                <label>Email</label>
                <input type="email" name="email" class="form-control" required><br>
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
            <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Pemasok</h3>
            <form id="formUpdate" class="ajax-form" method="POST">
                <label>ID Pemasok</label>
                <input type="text" id="edit-1" name="idpemasok" class="form-control" readonly><br>
                <label>Nama Pemasok</label>
                <input type="text" id="edit-2" name="namapemasok" class="form-control" required><br>
                <label>Alamat</label>
                <input type="text" id="edit-3" name="alamat" class="form-control" required><br>
                <label>Email</label>
                <input type="email" id="edit-4" name="email" class="form-control" required><br>
                <label>Telepon</label>
                <input type="text" id="edit-5" name="telp" class="form-control" required><br>
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