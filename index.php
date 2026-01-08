<?php require_once './modul/header.php';?>
<main class="container"></main>
<script>
	let contentindex = document.querySelector('main.container');
	let currentModul;
	(()=>{
		contentindex.innerHTML = `
		<div class="jumbotron">
			<h1 class="text-center">APLIKASI POINT OF SALES "Yusuf Dwi Putra"</h1>
			<p>Aplikasi ini digunakan untuk belajar praktikum matakuliah Sistem Basis Data membuat aplikasi Point Of Sales sederhana menggunakan PHP dan MySQL.</p>
		</div>`;
		console.log("Berhasil Load Halaman Index");
	})(); // Cek apakah data 'sudah_disapa' ada di storage
	if (!sessionStorage.getItem('sudah_disapa')) {
    let txt; let disclaimer = `Website ini belum sempurna dan saya Neporu/Yusuf DEV web ini hanya mengubah struktur agar mirip react dan melengkapi fitur insert dan edit sesuai yg sudah di sediakan di praktikum serta menambahkan fitur transaksi pembelian dan penjualan menggunakan AI meskpikun blom jadi, jadi mohon maaf jika ada bug atau error di dalamnya. Terimakasih 🙏`;
    let name = prompt('Siapa kamu?');
    if (name == null || name == "") {
        txt = `Tch dasar pelit 😒\n${disclaimer}`;
    } else {
        txt = `Selamat datang ${name} 😇\n${disclaimer}`;
	} alert(txt);
    // Simpan tanda bahwa user sudah disapa
    sessionStorage.setItem('sudah_disapa', 'true');
	} function replace_modul(x) {
		contentindex.innerHTML = '';
		fetch(`./modul/${x}.php`)
		.then(response => response.text())
		.then(data => {
			contentindex.innerHTML = data;
			currentModul = x;
		})
	} function openModal(x) {
		let modal = document.getElementById(`${x}`);
		modal.style.display = "block";
		window.onclick = function(event) {
			outermodal(event, x);
		}
	} function closeModal(x) {
		let modal = document.getElementById(`${x}`);
		modal.style.display = "none";
	} function outermodal(event, x) {
		let modal = document.getElementById(`${x}`);
		if (event.target == modal) {
			modal.style.display = "none";
		}
	} function editData(x, attr1, attr2, attr3, attr4, attr5){
		const attrs = [attr1, attr2, attr3, attr4, attr5];
		for (let i = 0; i < attrs.length; i++) {
			const el = document.getElementById(`edit-${i + 1}`);
			if (el) {
				el.value = attrs[i] !== undefined ? attrs[i] : '';
			}
		}
		openModal(x);
	} // Tambahkan event listener untuk form update
document.addEventListener('submit', function(e) {
	// Hanya proses form yang memiliki class 'ajax-form'
	if (e.target && e.target.classList.contains('ajax-form')) {
		e.preventDefault(); // MENCEGAH HALAMAN RELOAD/PINDAH

		// Khusus untuk hapus, beri konfirmasi dulu
        if (e.target.classList.contains('formHapus')) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
        }
        const formData = new FormData(e.target);
        const submitter = e.submitter;
        if (submitter && submitter.name) {
            formData.append(submitter.name, submitter.value || 'true');
        }

        let targetPHP = `modul/${currentModul}.php`;
        if (e.target.id === 'formPenjualan' || e.target.id === 'formPembelian') {
            targetPHP = 'modul/transaction_handler.php';
        }

        fetch(targetPHP, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                closeModal('modalTambah');
				closeModal('modalEdit');
                replace_modul(currentModul);
				setTimeout(() => {
					openModal('success');
				}, 800);
            } else {
                alert("Operasi CRUD Gagal: " + data);
            }
        })
        .catch(err => console.error("Error:", err));
    }
});

function viewTransactionDetails(type, id) {
    fetch(`modul/transaction_handler.php?get_details=true&type=${type}&id=${id}`)
    .then(response => response.text())
    .then(data => {
        document.getElementById('detailContent').innerHTML = data;
        openModal('modalDetail');
    })
    .catch(err => console.error("Error:", err));
}

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
        updateRow(e.target.closest('.item-row'));
    }
});

document.addEventListener('click', function(e) {
    if (e.target.id === 'add-item-btn') {
        const itemsContainer = document.getElementById('transaction-items');
        const firstItem = itemsContainer.querySelector('.item-row');
        const newItem = firstItem.cloneNode(true);
        
        // Reset values
        newItem.querySelector('select').selectedIndex = 0;
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        newItem.querySelector('.stok-info').textContent = '';
        
        // Show remove button
        newItem.querySelector('.remove-item-btn').style.display = 'inline-block';
        
        itemsContainer.appendChild(newItem);
        updateRemoveButtons();
    }
    if (e.target.classList.contains('remove-item-btn')) {
        e.target.closest('.item-row').remove();
        updateTotal();
        updateRemoveButtons();
    }
});

function updateRow(row) {
    const productSelect = row.querySelector('.product-select');
    const quantityInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input'); // For purchases
    const subtotalDisplay = row.querySelector('.subtotal-display');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    
    let price = 0;
    let quantity = parseInt(quantityInput.value) || 0;

    if (selectedOption && selectedOption.value) {
        if (document.getElementById('formPenjualan')) { // Sales form
            const stock = parseInt(selectedOption.getAttribute('data-stok'));
            price = parseInt(selectedOption.getAttribute('data-harga'));
            const stockInfo = row.querySelector('.stok-info');
            stockInfo.textContent = `Stok: ${stock}`;
            if (quantity > stock) {
                quantityInput.value = stock;
                quantity = stock;
            }
        } else { // Purchase form
            price = parseInt(priceInput.value) || 0;
        }
    }
    
    const subtotal = price * quantity;
    subtotalDisplay.value = "Rp " + subtotal.toLocaleString('id-ID');
    
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        
        let price = 0;
        let quantity = parseInt(quantityInput.value) || 0;

        if (selectedOption && selectedOption.value) {
            if (document.getElementById('formPenjualan')) {
                price = parseInt(selectedOption.getAttribute('data-harga'));
            } else {
                price = parseInt(priceInput.value) || 0;
            }
        }
        total += price * quantity;
    });
    document.getElementById('total-belanja').value = "Rp " + total.toLocaleString('id-ID');
}

function updateRemoveButtons() {
    const removeButtons = document.querySelectorAll('.remove-item-btn');
    if (removeButtons.length === 1) {
        removeButtons[0].style.display = 'none';
    } else {
        removeButtons.forEach(btn => btn.style.display = 'inline-block');
    }
}

// Initial call for existing forms
document.addEventListener('DOMContentLoaded', function() {
    if(document.getElementById('transaction-items')) {
        updateRemoveButtons();
    }
});
</script>