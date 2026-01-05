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