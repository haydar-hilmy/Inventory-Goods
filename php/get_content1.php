<?php
ob_start();

include 'func.php';

$get_id = $_GET["id"];

$query_data = mysqli_query($con, "SELECT * FROM barang WHERE id = '$get_id'");
$array_data = mysqli_fetch_array($query_data);

echo '
<input type="hidden" value="'. $array_data["id"] .'" name="id_barang" required readonly>
<input type="hidden" value="'. $array_data["nama_barang"] .'" name="nama_barang" required readonly>

<label for="supplier">Supplier</label>
<input class="not_allow" type="text" value="'. $array_data["supplier"] .'" name="supplier" id="supplier" required readonly><br>

<label for="satuan">Satuan</label>
<input class="not_allow" type="text" value="'. $array_data["satuan"] .'" name="satuan" id="satuan" required readonly><br>

<label for="stock">Stock</label>
<input class="not_allow" type="text" value="'. $array_data["stock"] .'" name="stock" id="stock" required readonly><br>

<label for="h_masuk">Harga Masuk</label>
<input class="not_allow" type="number" value="'. $array_data["harga_masuk"] .'" name="harga_masuk" id="h_masuk" required readonly><br>

<label for="jumlah">Jumlah</label>
<input class="" min="1" type="number" oninput="hitung_total_harga(this.value)" value="" name="jumlah" id="jumlah" required><br>

<label for="t_harga">Total Harga</label>
<input class="not_allow" type="number" value="" name="total_harga" id="t_harga" required readonly><br>

';

?>