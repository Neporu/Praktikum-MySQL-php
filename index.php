<?php require_once './modul/header.php';?>
<main class="container"></main>
<script>
	let contentindex = document.querySelector('main.container');
	(()=>{
		contentindex.innerHTML = `
		<div class="jumbotron">
			<h1 class="text-center">APLIKASI POINT OF SALES "Yusuf Dwi Putra"</h1>
			<p>Aplikasi ini digunakan untuk belajar praktikum matakuliah Sistem Basis Data membuat aplikasi Point Of Sales sederhana menggunakan PHP dan MySQL.</p>
		</div>`;
		console.log("Berhasil Load Halaman Index");
	})();
	function replace_modul(x) {
		contentindex.innerHTML = '';
		fetch(`./modul/${x}.php`)
		.then(response => response.text())
		.then(data => {
			contentindex.innerHTML = data;
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
}
</script>