<?php
require_once 'connect.php';
require_once 'header.php';
?>
<div class="container">
    <?php
    if (isset($_POST['addnew'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $sandi = $_POST['sandi'];
    $jabatan = $_POST['jabatan'];
    $nama = $_POST['nama'];

    if (empty($id) || empty($username) || empty($sandi) || empty($jabatan) || empty($nama)) {
        echo "<div class='alert alert-warning'>Seluruh data harus diisi!</div>";
    }

    // Validasi panjang sandi
    elseif (strlen($sandi) < 5) {
        echo "<div class='alert alert-danger'>Sandi minimal 5 karakter!</div>";
    }

    else {
        // Cek apakah sandi sudah ada di database
        $cek = mysqli_query($con, "SELECT * FROM tbpengguna WHERE sandi='$sandi'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<div class='alert alert-danger'>Sandi sudah digunakan pengguna lain, silakan ganti!</div>";
        }
        else {
            // Simpan ke database
            $sql = "INSERT INTO tbpengguna (id, username, sandi, jabatan, nama) 
                    VALUES ('$id', '$username', '$sandi', '$jabatan', '$nama')";

            if ($con->query($sql) === TRUE) {
                header("Location: pengguna.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Data gagal ditambahkan: ".$con->error."</div>";
            }
        }
    }
}
    ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box">
                <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Pengguna</h3>
                <form action="" method="POST">
                    <label for="id">Id Pengguna</label>
                    <input type="number" id="id" name="id" class="form-control"><br>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control"><br>

                    <label for="sandi">Sandi</label>
                    <input type="password" id="sandi" name="sandi" class="form-control"><br>

                    <label for="jabatan">Jabatan</label>
                    <select name="jabatan" id="jabatan" class="form-control" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="kasir">kasir</option>
                        <option value="admin">admin</option>
                    </select>
                    <br>

                    <label for="nama">Nama Pengguna</label>
                    <input type="text" id="nama" name="nama" class="form-control"><br>

                    <input type="submit" name="addnew" class="btn btn-success" value="Tambah">
                    <a href="pengguna.php" class="btn btn-info">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
