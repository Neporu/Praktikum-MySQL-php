<?php  require_once './../connect.php';
// Proses penghapusan
if (isset($_POST['delete'])) {
    $id = $_POST['id']; 
    $sql = "DELETE FROM tbkategori WHERE idkategori = '$id'";
    if ($con->query($sql) === TRUE) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data</div>";
    }} // <!-- FITUR INSERT DATA -->
if (isset($_POST['addnew'])) {
    // Ambil data dari form
    $idkategori = $_POST['idkategori'];
    $nama_kategori = $_POST['nama_kategori'];
    // Validasi input
    if (empty($idkategori) || empty($nama_kategori)) {
        echo "<div class='alert alert-warning'>Seluruh data harus diisi!</div>";
    } else {
        // Query untuk memasukkan ke tabel kategori
        $sql = "INSERT INTO tbkategori (idkategori, nama_kategori) 
                VALUES ('$idkategori', '$nama_kategori')";

        if ($con->query($sql) === TRUE) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Data gagal ditambahkan: " . $con->error . "</div>";
        }}} // Proses Update
if (isset($_POST['update'])) {
    if (empty($_POST['idkategori']) || empty($_POST['nama_kategori'])) {
        echo "<div class='alert alert-warning'>Semua field harus diisi.</div>";
    } else {
        $idkategori = $_POST['idkategori'];
        $nama_kategori = $_POST['nama_kategori'];
        $sql = "UPDATE tbkategori SET nama_kategori = '$nama_kategori' WHERE idkategori = '$idkategori'";
        if ($con->query($sql) === TRUE) {
            header("Location: ../index.php"); 
            exit();
        } else {
            echo "<div class='alert alert-danger'>Data gagal diubah: " . $con->error . "</div>";
        }}} 
// Ambil data kategori
$sql = "SELECT * FROM tbkategori order by idkategori";
$result = $con->query($sql);
if ($result->num_rows > 0) {?>
    <h2>Data Kategori</h2>
    <br>
    <a href="#" class="btn btn-info" onclick="openModal(1)">Tambah Data</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Id Kategori</th>
            <th>Nama Kategori</th>
            <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['idkategori']; ?></td>
            <td><?php echo $row['nama_kategori']; ?></td>
            <td>
                <a href="#" class="btn btn-info btn-sm" onclick="openModal('<?php echo $row['idkategori'];?>')">Ubah</a>
                <!-- <a href="./modul/editkategori.php?id=<?php echo $row['idkategori']; ?>" class="btn btn-info btn-sm">Ubah</a> -->
                <form method="post" action="./modul/kategori.php" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    <input type="hidden" name="id" value="<?php echo $row['idkategori']; ?>">
                    <input type="submit" name="delete" value="Hapus" class="btn btn-danger btn-sm">
                </form> 
            </td>
        </tr>
        <div id="<?php echo $row['idkategori'];?>" class="modal">
            <div class="modal-content">
                <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;Ubah Kategori</h3>
                <form action="modul/kategori.php" method="POST">
                    <label for="idkategori">Id Kategori</label>
                    <input type="text" name="idkategori" value="<?php echo $row['idkategori'];?>" class="form-control" readonly><br>

                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="<?php echo $row['nama_kategori']; ?>" class="form-control"><br>

                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <a href="#" class="btn btn-info" onclick="closeModal('<?php echo $row['idkategori'];?>')">Batal</a>
                </form>
            </div>
        </div>
        <?php } ?>
    </table>
    <div id="1" class="modal">
        <div class="modal-content">
            <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Kategori</h3>
            <form action="modul/kategori.php" method="POST" onsubmit="">
                <label for="idkategori">Id Kategori</label>
                <input type="text" id="idkategori" name="idkategori" class="form-control"><br>

                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="form-control"><br>

                <button type="submit" name="addnew" class="btn btn-success">Tambah</button>
                <a href="#" class="btn btn-info" onclick="closeModal(1)">Batal</a>
            </form> 
        </div>
    </div>
<?php } else {echo "<br><br><div class='alert alert-warning'>Tidak ada data Kategori.</div>";}?>