<?php  require_once './../connect.php';

// Proses Delete
if (isset($_POST['delete'])) {
    $pk = $_POST['id']; 
    
    $check_detailjual_sql = "SELECT COUNT(*) as count FROM tbdetailjual WHERE kode = '$pk'";
    $check_detailjual_result = $con->query($check_detailjual_sql);
    if ($check_detailjual_result->fetch_assoc()['count'] > 0) {
        echo "Gagal menghapus: Produk ini tercatat dalam transaksi penjualan.";
        exit();
    }

    $check_detailbeli_sql = "SELECT COUNT(*) as count FROM tbdetailbeli WHERE kode = '$pk'";
    $check_detailbeli_result = $con->query($check_detailbeli_sql);
    if ($check_detailbeli_result->fetch_assoc()['count'] > 0) {
        echo "Gagal menghapus: Produk ini tercatat dalam transaksi pembelian.";
        exit();
    }

    $sql = "DELETE FROM tbproduk WHERE kode = '$pk'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal menghapus data: " . $con->error;
    }
    exit();
}

// Proses Insert
if (isset($_POST['addnew'])) {
    $new1 = $_POST['kode'];
    $new2 = $_POST['nama'];
    $new3 = $_POST['idkategori'];
    $new4 = $_POST['harga'];
    $new5 = $_POST['stok'];
    
    if (empty($new1) || empty($new2) || empty($new3) || !isset($new4) || !isset($new5)) {
        echo "Semua field harus diisi!";
        exit();
    }
    
    $check_sql = "SELECT kode FROM tbproduk WHERE kode = '$new1'";
    $check_result = $con->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "Gagal: Kode Produk '$new1' sudah ada.";
        exit();
    }

    $sql = "INSERT INTO tbproduk (kode, nama, idkategori, harga, stok) 
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
    $up1 = $_POST['kode'];
    $up2 = $_POST['nama'];
    $up3 = $_POST['idkategori'];
    $up4 = $_POST['harga'];
    $up5 = $_POST['stok'];

    if (empty($up1) || empty($up2) || empty($up3) || !isset($up4) || !isset($up5)) {
        echo "Semua field harus diisi.";
        exit();
    }

    $sql = "UPDATE tbproduk SET nama = '$up2', idkategori = '$up3', harga = '$up4', stok = '$up5' WHERE kode = '$up1'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Gagal mengubah data: " . $con->error;
    }
    exit();
}

// Ambil data produk dan kategori
$sql = "SELECT p.*, k.nama_kategori FROM tbproduk p JOIN tbkategori k ON p.idkategori = k.idkategori ORDER BY p.kode";
$result = $con->query($sql);

$kategori_sql = "SELECT * FROM tbkategori ORDER BY nama_kategori";
$kategori_result = $con->query($kategori_sql);
$kategori_options = [];
while($kategori_row = $kategori_result->fetch_assoc()){
    $kategori_options[] = $kategori_row;
}

if ($result->num_rows > 0) {?>
    <h2>Data Produk</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal('modalTambah')">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
            $attr1 = $row['kode'];
            $attr2 = $row['nama'];
            $attr3 = $row['idkategori'];
            $attr4 = $row['harga'];
            $attr5 = $row['stok'];
        ?>
        <tr>
            <td><?php echo $attr1 ?></td>
            <td><?php echo $attr2 ?></td>
            <td><?php echo $row['nama_kategori'] ?></td>
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
<?php } else { echo "<br><br><div class='alert alert-warning'>Tidak ada data Produk.</div>"; } ?>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Produk</h3>
            <form id="formTambah" class="ajax-form" method="POST">
                <label>Kode Produk</label>
                <input type="text" name="kode" class="form-control" required><br>
                <label>Nama Produk</label>
                <input type="text" name="nama" class="form-control" required><br>
                <label>Kategori</label>
                <select name="idkategori" class="form-control" required>
                    <option value="" selected disabled>-- Pilih Kategori --</option>
                    <?php foreach($kategori_options as $k): ?>
                        <option value="<?php echo $k['idkategori']; ?>"><?php echo $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required><br>
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required><br>
                <button type="submit" name="addnew" class="btn btn-success">Tambah</button>
                <a href="#" class="btn btn-info" onclick="closeModal('modalTambah')">Batal</a>
            </form> 
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Produk</h3>
            <form id="formUpdate" class="ajax-form" method="POST">
                <label>Kode Produk</label>
                <input type="text" id="edit-1" name="kode" class="form-control" readonly><br>
                <label>Nama Produk</label>
                <input type="text" id="edit-2" name="nama" class="form-control" required><br>
                <label>Kategori</label>
                <select id="edit-3" name="idkategori" class="form-control" required>
                    <option value="" disabled>-- Pilih Kategori --</option>
                    <?php foreach($kategori_options as $k): ?>
                        <option value="<?php echo $k['idkategori']; ?>"><?php echo $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <label>Harga</label>
                <input type="number" id="edit-4" name="harga" class="form-control" required><br>
                <label>Stok</label>
                <input type="number" id="edit-5" name="stok" class="form-control" required><br>
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