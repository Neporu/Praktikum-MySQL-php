<?php  require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $pk = $_POST['id']; 
    // Cek ketergantungan di tbproduk
    $check_sql = "SELECT COUNT(*) as count FROM tbproduk WHERE idkategori = '$pk'";
    $check_result = $con->query($check_sql);
    $row = $check_result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "Gagal menghapus: Kategori ini digunakan oleh produk lain.";
        exit();
    }
    $sql = "DELETE FROM tbkategori WHERE idkategori = '$pk'";
    if ($con->query($sql) === TRUE) {
        echo "success";
        exit();
    } else {
        echo "error";
        // echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }} // <!-- FITUR INSERT DATA -->
if (isset($_POST['addnew'])) {
    // Ambil data dari form
    $new1 = $_POST['idkategori'];
    $new2 = $_POST['nama_kategori'];
    // Validasi input
    if (empty($new1) || empty($new2)) {
        echo "Semua field harus diisi!";
        exit();
    } else {
        // Cek apakah ID Kategori sudah ada
        $check_sql = "SELECT idkategori FROM tbkategori WHERE idkategori = '$new1'";
        $check_result = $con->query($check_sql);
        if ($check_result->num_rows > 0) {
            echo "Gagal: Id Kategori '$new1' sudah ada.";
            exit();
        } // Query untuk memasukkan ke tabel kategori
        $sql = "INSERT INTO tbkategori (idkategori, nama_kategori) 
                VALUES ('$new1', '$new2')";

        if ($con->query($sql) === TRUE) {
            echo "success";
            exit();
        } else {
            echo "error";
            // echo "<div class='alert alert-danger'>Data gagal ditambahkan: " . $con->error . "</div>";
        }}} // Proses Update
if (isset($_POST['update'])) {
    if (empty($_POST['idkategori']) || empty($_POST['nama_kategori'])) {
        echo "<div class='alert alert-warning'>Semua field harus diisi.</div>";
    } else {
        $up1 = $_POST['idkategori'];
        $up2 = $_POST['nama_kategori'];
        $sql = "UPDATE tbkategori SET nama_kategori = '$up2' WHERE idkategori = '$up1'";
        if ($con->query($sql) === TRUE) {
            // header("Location: ../index.php"); 
            echo "success";
            exit();
        } else {
            echo "error";
            // echo "<div class='alert alert-danger'>Data gagal diubah: " . $con->error . "</div>";
        }}} 
// Ambil data
$sql = "SELECT * FROM tbkategori order by idkategori";
$result = $con->query($sql);
if ($result->num_rows > 0) {?>
    <h2>Data Kategori</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal('modalTambah')">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Id Kategori</th>
            <th>Nama Kategori</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
        $attr1 = $row['idkategori'];
        $attr2 = $row['nama_kategori']
        ?>
        <tr>
            <td><?php echo $attr1 ?></td>
            <td><?php echo $attr2 ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="editData('modalEdit','<?php echo $attr1?>', '<?php echo $attr2?>')">
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
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Kategori</h3>
            <form id="formTambah" class="ajax-form" method="POST">
                <label for="idkategori">Id Kategori</label>
                <input type="text" id="idkategori" name="idkategori" class="form-control"><br>

                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="form-control"><br>

                <button type="submit" name="addnew" class="btn btn-success">Tambah</button>
                <a href="#" class="btn btn-info" onclick="closeModal('modalTambah')">Batal</a>
            </form> 
        </div>
    </div>
    <div id="modalEdit" class="modal">
            <div class="modal-content">
                <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Kategori</h3>
                <form id="formUpdate" class="ajax-form" method="POST">
                    <label for="idkategori">Id Kategori</label>
                    <input type="text" id="edit-1" name="idkategori" class="form-control" readonly><br>

                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" id="edit-2" name="nama_kategori" class="form-control"><br>

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