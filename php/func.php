<?php 

$con = mysqli_connect("localhost", "root", "", "inventaris_toko");

if(!$con){
	echo "<script>
			alert('Server Dalam Masalah ^_^ ');
		</script>";
	echo "<h1>Server Dalam Masalah ^_^</h1>";
	echo "<img width=200 src='https://media.tenor.com/o-XAlTCT0DMAAAAC/cute-sad.gif'>";
	exit;
}

function addSupplier($data)
{
	global $con;
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$alamat = stripslashes(htmlspecialchars($data["alamat"]));
	$email = stripslashes(htmlspecialchars($data["email"]));
	$telp = stripslashes(htmlspecialchars($data["telp"]));

	$ceknama = mysqli_query($con, "SELECT * FROM supplier WHERE nama_supplier = '$name'");

	if (mysqli_fetch_assoc($ceknama)){
		echo "<script>
			alert('Nama supplier sudah terdaftar, coba ganti nama yang lain');
		</script>";
		return false;
	}

	$insert_sign = mysqli_query($con, "INSERT INTO supplier (nama_supplier, alamat, email_supplier, no_telp) VALUES ('$name', '$alamat', '$email', '$telp')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}

function editSupplier($data)
{
	global $con;
	$id = $data["id"];
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$alamat = stripslashes(htmlspecialchars($data["alamat"]));
	$email = stripslashes(htmlspecialchars($data["email"]));
	$telp = stripslashes(htmlspecialchars($data["telp"]));

	mysqli_query($con, "UPDATE supplier SET nama_supplier = '$name', alamat = '$alamat', email_supplier = '$email', no_telp = '$telp' WHERE id = '$id'");

	return mysqli_affected_rows($con);
}







function addPengguna($data)
{
	global $con;
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$email = stripslashes(htmlspecialchars($data["email"]));
	$jabatan = stripslashes(htmlspecialchars($data["jabatan"]));
	$password = stripslashes(htmlspecialchars($data["password"]));

	$ceknama = mysqli_query($con, "SELECT * FROM master WHERE nama_pengguna = '$name'");

	if (mysqli_fetch_assoc($ceknama)){
		echo "<script>
			alert('Nama pengguna sudah terdaftar, coba ganti nama yang lain');
		</script>";
		return false;
	}

	$insert_sign = mysqli_query($con, "INSERT INTO master (nama_pengguna, kata_sandi, email, jabatan) VALUES ('$name', '$password', '$email', '$jabatan')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}

function editPengguna($data)
{
	global $con;
	$id = $data["id"];
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$email = stripslashes(htmlspecialchars($data["email"]));
	$jabatan = stripslashes(htmlspecialchars($data["jabatan"]));
	$password = stripslashes(htmlspecialchars($data["password"]));

	mysqli_query($con, "UPDATE master SET nama_pengguna = '$name', kata_sandi = '$password', email = '$email', jabatan = '$jabatan' WHERE id = '$id'");

	return mysqli_affected_rows($con);
}







function addBarang($data)
{
	global $con;
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$satuan = stripslashes(htmlspecialchars($data["satuan"]));
	$harga_masuk = stripslashes(htmlspecialchars($data["harga_masuk"]));
	$harga_keluar = stripslashes(htmlspecialchars($data["harga_keluar"]));
	$supplier = stripslashes(htmlspecialchars($data["supplier"]));

	$insert_sign = mysqli_query($con, "INSERT INTO barang (nama_barang, satuan, harga_masuk, harga_keluar, supplier) VALUES ('$name', '$satuan', '$harga_masuk', '$harga_keluar', '$supplier')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}

function editBarang($data)
{
	global $con;
	$id = $data["id"];
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$satuan = stripslashes(htmlspecialchars($data["satuan"]));
	$harga_masuk = stripslashes(htmlspecialchars($data["harga_masuk"]));
	$harga_keluar = stripslashes(htmlspecialchars($data["harga_keluar"]));
	$supplier = stripslashes(htmlspecialchars($data["supplier"]));

	mysqli_query($con, "UPDATE barang SET nama_barang = '$name', satuan = '$satuan', harga_masuk = '$harga_masuk', harga_keluar = '$harga_keluar', supplier = '$supplier' WHERE id = '$id'");

	return mysqli_affected_rows($con);
}






function addPelanggan($data)
{
	global $con;
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$alamat = stripslashes(htmlspecialchars($data["alamat"]));
	$no_telp = stripslashes(htmlspecialchars($data["telp"]));

	$ceknama = mysqli_query($con, "SELECT * FROM pelanggan WHERE nama_pelanggan = '$name'");

	if (mysqli_fetch_assoc($ceknama)){
		echo "<script>
			alert('Nama pelanggan sudah terdaftar, coba ganti nama yang lain');
		</script>";
		return false;
	}

	$insert_sign = mysqli_query($con, "INSERT INTO pelanggan (nama_pelanggan, alamat, no_telp) VALUES ('$name', '$alamat', '$no_telp')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}

function editPelanggan($data)
{
	global $con;
	$id = $data["id"];
	$name = stripslashes(htmlspecialchars($data["nama"]));
	$alamat = stripslashes(htmlspecialchars($data["alamat"]));
	$no_telp = stripslashes(htmlspecialchars($data["telp"]));

	mysqli_query($con, "UPDATE pelanggan SET nama_pelanggan = '$name', alamat = '$alamat', no_telp = '$no_telp' WHERE id = '$id'");

	return mysqli_affected_rows($con);
}









function addT_masuk($data)
{
	global $con;
	$tgl_masuk = stripslashes(htmlspecialchars($data["tgl_masuk"]));
	$id_barang = stripslashes(htmlspecialchars($data["id_barang"]));
	$nama_barang = stripslashes(htmlspecialchars($data["nama_barang"]));
	$supplier = stripslashes(htmlspecialchars($data["supplier"]));
	$satuan = stripslashes(htmlspecialchars($data["satuan"]));
	$harga_masuk = stripslashes(htmlspecialchars($data["harga_masuk"]));
	$jumlah = stripslashes(htmlspecialchars($data["jumlah"]));
	$total_harga = stripslashes(htmlspecialchars($data["total_harga"]));

	$insert_sign = mysqli_query($con, "INSERT INTO transaksi_masuk (tgl_masuk, id_barang, nama_barang, satuan, nama_supplier, harga_masuk, jumlah, total_harga) VALUES ('$tgl_masuk', '$id_barang', '$nama_barang', '$satuan', '$supplier', '$harga_masuk', '$jumlah', '$total_harga')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}







function addT_keluar($data)
{
	global $con;
	$tgl_keluar = stripslashes(htmlspecialchars($data["tgl_keluar"]));
	$id_barang = stripslashes(htmlspecialchars($data["id_barang"]));
	$nama_barang = stripslashes(htmlspecialchars($data["nama_barang"]));
	$satuan = stripslashes(htmlspecialchars($data["satuan"]));
	$id_pelanggan = stripslashes(htmlspecialchars($data["id_pelanggan"]));
	$nama_pelanggan = stripslashes(htmlspecialchars($data["nama_pelanggan"]));
	$harga_keluar = stripslashes(htmlspecialchars($data["harga_keluar"]));
	$jumlah = stripslashes(htmlspecialchars($data["jumlah"]));
	$total_harga = stripslashes(htmlspecialchars($data["total_harga"]));

	$insert_sign = mysqli_query($con, "INSERT INTO transaksi_keluar (tgl_keluar, id_barang, nama_barang, satuan, id_pelanggan, nama_pelanggan, harga_keluar, jumlah, total_harga)
	 VALUES ('$tgl_keluar', '$id_barang', '$nama_barang', '$satuan', '$id_pelanggan', '$nama_pelanggan', '$harga_keluar', '$jumlah', '$total_harga')");

	if (!$insert_sign){
		echo "<script>
			alert('Maaf, Operasi Gagal :(');
		</script>";
		return false;
	}

	return mysqli_affected_rows($con);
}


?>