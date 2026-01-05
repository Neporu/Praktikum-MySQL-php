<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Neporu</title>
	<link rel="shortcut icon" href="./assets/Universitas Amikom Purwokerto.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="./style.css">
</head>
<body>
	<?php require_once 'header.php';?>
	<main class="container"></main>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
			let modal = document.getElementById(`myModal ${x}`);
			modal.style.display = "block";
		} function closeModal(x) {
			let modal = document.getElementById(`myModal ${x}`);
			modal.style.display = "none";
		} window.onclick = function(event) {
			let modal = document.getElementById('myModal');
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
</body>
</html>