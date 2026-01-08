<?php require_once './../connect.php';
// Ambil data untuk dropdown
$pemasok = $con->query("SELECT * FROM tbpemasok ORDER BY namapemasok");
$products = $con->query("SELECT * FROM tbproduk ORDER BY nama");
?>
<h2>Transaksi Pembelian Baru</h2>
<form id="formPembelian" class="ajax-form" method="POST">
    <div class="form-group">
        <label>Nota Beli</label>
        <input type="text" name="notabeli" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tanggal Transaksi</label>
        <input type="date" name="tgl" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    <div class="form-group">
        <label>Pemasok</label>
        <select name="idpemasok" class="form-control" required>
            <option value="" selected disabled>-- Pilih Pemasok --</option>
            <?php while($row = $pemasok->fetch_assoc()): ?>
            <option value="<?php echo $row['idpemasok']; ?>"><?php echo $row['namapemasok']; ?></option>
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
                    <option value="<?php echo $row['kode']; ?>" data-harga="<?php echo $row['harga']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jml[]" class="form-control quantity-input" min="1" required>
            </div>
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="number" name="hargabeli[]" class="form-control price-input" required>
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
        <input type="text" id="total-belanja" name="totalbeli" class="form-control" readonly>
    </div>
    <input type="hidden" name="id" value="1"> <!-- Ganti dengan ID user yang login -->
    <button type="submit" name="addpurchase" class="btn btn-success">Simpan Transaksi</button>
    <a href="#" onclick="replace_modul('pembelian')" class="btn btn-warning">Batal</a>
</form>