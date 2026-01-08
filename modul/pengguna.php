<?php  require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $pk = $_POST['id']; 
    // Cek ketergantungan di tbpenjualan
    $check_penjualan_sql = "SELECT COUNT(*) as count FROM tbpenjualan WHERE id = '$pk'";
    $check_penjualan_result = $con->query($check_penjualan_sql);
    $penjualan_row = $check_penjualan_result->fetch_assoc();
    if ($penjualan_row['count'] > 0) {
        echo "Gagal menghapus: Pengguna ini memiliki riwayat transaksi penjualan.";
        exit();
    } // Cek ketergantungan di tbpembelian
    $check_pembelian_sql = "SELECT COUNT(*) as count FROM tbpembelian WHERE id = '$pk'";
    $check_pembelian_result = $con->query($check_pembelian_sql);
    $pembelian_row = $check_pembelian_result->fetch_assoc();
    if ($pembelian_row['count'] > 0) {
        echo "Gagal menghapus: Pengguna ini memiliki riwayat transaksi pembelian.";
        exit();
    }
    $sql = "DELETE FROM tbpengguna WHERE id = '$pk'";
    if ($con->query($sql) === TRUE) {
        echo "success";
        exit();
    } else {
        echo "error";
        // echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }} // <!-- FITUR INSERT DATA -->
if (isset($_POST['addnew'])) {
    // Ambil data dari form
    $new2 = $_POST['username'];
    $new3 = $_POST['sandi'];
    $new4 = $_POST['jabatan'];
    $new5 = $_POST['nama'];
    
    // Validasi input
    if (empty($new2) || empty($new3) || empty($new4) || empty($new5)) {
        echo "Semua field harus diisi!";
        exit();
    } else {
        // Cek duplikasi username
        $check_user_sql = "SELECT username FROM tbpengguna WHERE username = '$new2'";
        $check_user_result = $con->query($check_user_sql);
        if ($check_user_result->num_rows > 0) {
            echo "Gagal: Username '$new2' sudah digunakan.";
            exit();
        }

        // Query untuk memasukkan ke tabel pengguna
        $sql = "INSERT INTO tbpengguna (username, sandi, jabatan, nama) 
                VALUES ('$new2', '$new3', '$new4', '$new5')";

        if ($con->query($sql) === TRUE) {
            echo "success";
            exit();
        } else {
            echo "Gagal menambahkan data: " . $con->error;
            exit();
        }}} // Proses Update
if (isset($_POST['update'])) {
    if (empty($_POST['id']) || empty($_POST['username']) || empty($_POST['sandi']) || empty($_POST['jabatan']) || empty($_POST['nama'])) {
        echo "Semua field harus diisi.";
        exit();
    } else {
        $up1 = $_POST['id'];
        $up2 = $_POST['username'];
        $up3 = $_POST['sandi'];
        $up4 = $_POST['jabatan'];
        $up5 = $_POST['nama'];

        // Cek duplikasi username pada user lain
        $check_user_sql = "SELECT username FROM tbpengguna WHERE username = '$up2' AND id != '$up1'";
        $check_user_result = $con->query($check_user_sql);
        if ($check_user_result->num_rows > 0) {
            echo "Gagal: Username '$up2' sudah digunakan oleh pengguna lain.";
            exit();
        }

        $sql = "UPDATE tbpengguna SET username = '$up2', sandi = '$up3', jabatan = '$up4', nama = '$up5' WHERE id = '$up1'";
        if ($con->query($sql) === TRUE) {
            // header("Location: ../index.php"); 
            echo "success";
            exit();
        } else {
            echo "Gagal mengubah data: " . $con->error;
            exit();
        }}} 
// Ambil data
$sql = "SELECT * FROM tbpengguna order by id";
$result = $con->query($sql);
if ($result->num_rows > 0) {?>
    <h2>Data Pengguna</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal('modalTambah')">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Sandi</th>
            <th>Jabatan</th>
            <th>Nama</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
        $attr1 = $row['id'];
        $attr2 = $row['username'];
        $attr3 = $row['sandi'];
        $attr4 = $row['jabatan'];
        $attr5 = $row['nama'];
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
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Pengguna</h3>
            <form id="formTambah" class="ajax-form" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required><br>

                <label for="sandi">Sandi</label>
                <input type="text" id="sandi" name="sandi" class="form-control" required><br>

                <label for="jabatan">Jabatan</label>
                <select name="jabatan" id="jabatan" class="form-control" required>
                    <option value="" selected disabled>-- Pilih Jabatan --</option>
                    <option value="kasir">kasir</option>
                    <option value="admin">admin</option>
                </select>
                <br>

                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" required><br>

                <button type="submit" name="addnew" class="btn btn-success">Tambah</button>
                <a href="#" class="btn btn-info" onclick="closeModal('modalTambah')">Batal</a>
            </form> 
        </div>
    </div>
    <div id="modalEdit" class="modal">
            <div class="modal-content">
                <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Pengguna</h3>
                <form id="formUpdate" class="ajax-form" method="POST">
                    <label for="id">Id</label>
                    <input type="text" id="edit-1" name="id" class="form-control" readonly><br>

                    <label for="username">Username</label>
                    <input type="text" id="edit-2" name="username" class="form-control"><br>

                    <label for="sandi">Sandi</label>
                    <input type="text" id="edit-3" name="sandi" class="form-control"><br>

                    <label for="jabatan">Jabatan</label>
                    <select name="jabatan" id="edit-4" class="form-control">
                        <option value="" disabled>-- Pilih Jabatan --</option>
                        <option value="kasir" <?php if($attr4 == "kasir") echo 'selected'; ?>>kasir</option>
                        <option value="admin" <?php if($attr4 == "admin") echo 'selected'; ?>>admin</option>
                    </select>
                    <br>

                    <label for="nama">Nama</label>
                    <input type="text" id="edit-5" name="nama" class="form-control"><br>

                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <a href="#" class="btn btn-info" onclick="closeModal('modalEdit')">Batal</a>
                </form>
            </div>
    </div>
    <div id="success" class="modal" onclick="closeModal('success');">
        <div class="modal-content text-center">
            <h1 style="color: #A8DF8E;"><i class="glyphicon glyphicon-ok"></i>&nbsp;<br>Sukses</h1>
        </div>
    </div>
<?php } else {echo "<br><br><div class='alert alert-warning'>Tidak ada data Kategori.</div>";}?>