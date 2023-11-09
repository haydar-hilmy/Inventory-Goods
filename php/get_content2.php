<?php
ob_start();

include 'func.php';

$get_id_barang = $_GET["id"];
$get_id_pelanggan = $_GET["id_pelanggan"];

$query_pelanggan = mysqli_query($con, "SELECT * FROM pelanggan WHERE id = '$get_id_pelanggan'");
$array_pelanggan = mysqli_fetch_array($query_pelanggan);

$query_barang = mysqli_query($con, "SELECT * FROM barang WHERE id = '$get_id_barang'");
$array_barang = mysqli_fetch_array($query_barang);

echo '
<input type="hidden" value="'. $array_pelanggan["id"] .'" name="id_pelanggan" required readonly>
<input type="hidden" value="'. $array_pelanggan["nama_pelanggan"] .'" name="nama_pelanggan" required readonly>

<input type="hidden" value="'. $array_barang["id"] .'" name="id_barang" required readonly>
<input type="hidden" value="'. $array_barang["nama_barang"] .'" name="nama_barang" required readonly>

<label for="satuan">Satuan</label>
<input class="not_allow" type="text" value="'. $array_barang["satuan"] .'" name="satuan" id="satuan" required readonly><br>

<label for="stock">Stock</label>
<input class="not_allow" type="text" value="'. $array_barang["stock"] .'" name="stock" id="stock" required readonly><br>

<label for="h_keluar">Harga Keluar</label>
<input class="not_allow" type="number" value="'. $array_barang["harga_keluar"] .'" name="harga_keluar" id="h_keluar" required readonly><br>

<label for="jumlah">Jumlah</label>
<input class="" type="number" min="1" max="'. $array_barang["stock"] .'" oninput="hitung_total_harga(this.value)" value="" name="jumlah" id="jumlah" required><br>

<label for="t_harga">Total Harga</label>
<input class="not_allow" type="number" value="" name="total_harga" id="t_harga" required readonly><br>

';

?>