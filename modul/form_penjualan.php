<?php require_once './../connect.php';
// Ambil data untuk dropdown
$members = $con->query("SELECT * FROM tbmember ORDER BY nama_member");
$products = $con->query("SELECT * FROM tbproduk WHERE stok > 0 ORDER BY nama");
?>
<h2>Transaksi Penjualan Baru</h2>
<form id="formPenjualan" class="ajax-form" method="POST">
    <div class="form-group">
        <label>Tanggal Transaksi</label>
        <input type="date" name="tgltransaksi" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    <div class="form-group">
        <label>Member (Opsional)</label>
        <select name="idmember" class="form-control">
            <option value="">-- Pelanggan Umum --</option>
            <?php while($row = $members->fetch_assoc()): ?>
            <option value="<?php echo $row['idmember']; ?>"><?php echo $row['nama_member']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <hr>
    <h4>Item Transaksi</h4>
    <div id="transaction-items">
        <!-- Item pertama -->
        <div class="item-row">
            <div class="form-group">
                <label>Produk</label>
                <select name="kode[]" class="form-control product-select" required>
                    <option value="" selected disabled>-- Pilih Produk --</option>
                    <?php mysqli_data_seek($products, 0); ?>
                    <?php while($row = $products->fetch_assoc()): ?>
                    <option value="<?php echo $row['kode']; ?>" data-harga="<?php echo $row['harga']; ?>" data-stok="<?php echo $row['stok']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jml[]" class="form-control quantity-input" min="1" required>
                <small class="stok-info"></small>
            </div>
            <div class="form-group">
                <label>Subtotal</label>
                <input type="text" name="subtotal[]" class="form-control subtotal-display" readonly>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-item-btn" style="display:none;">Hapus</button>
            <hr>
        </div>
    </div>
    <button type="button" id="add-item-btn" class="btn btn-primary">Tambah Item</button>
    <hr>
    <div class="form-group">
        <label>Total Belanja</label>
        <input type="text" id="total-belanja" name="total" class="form-control" readonly>
    </div>
    <input type="hidden" name="id" value="1"> <!-- Ganti dengan ID user yang login -->
    <button type="submit" name="addsale" class="btn btn-success">Simpan Transaksi</button>
    <a href="#" onclick="replace_modul('penjualan')" class="btn btn-warning">Batal</a>
</form>