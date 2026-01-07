<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Neporu</title>
	<link rel="shortcut icon" href="assets/Universitas Amikom Purwokerto.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<nav class="container navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data Master
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="replace_modul('pengguna')">Pengguna</a></li>
							<li><a href="#" onclick="replace_modul('kategori')">Kategori</a></li>
							<li><a href="#" onclick="replace_modul('pemasok')">Pemasok</a></li>
							<li><a href="#" onclick="replace_modul('member')">Member</a></li>
							<li><a href="#" onclick="replace_modul('produk')">Produk</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data Transaksi
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="replace_modul('penjualan')">Penjualan</a></li>
							<li><a href="#" onclick="replace_modul('pembelian')">Pembelian</a></li>
						</ul>
					</li>
					<li><a href="#" onclick="replace_modul('tentang')">Tentang Kami</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>