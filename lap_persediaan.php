<?php
session_start();

include 'php/func.php';

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$get_username = $_SESSION['login'];
$query_data = mysqli_query($con, "SELECT * FROM master WHERE nama_pengguna = '$get_username'");
$array_data = mysqli_fetch_array($query_data);

$query_barang = mysqli_query($con, "SELECT * FROM barang");

if (isset($_GET['cari'])) {
    $pencarian = $_GET['barang'];
    $query_t_masuk = mysqli_query($con, "SELECT tgl_masuk AS tanggal, id_barang AS id_barang, id AS kode_transaksi, jumlah, harga_masuk AS harga, total_harga, 'masuk' AS jenis_transaksi FROM transaksi_masuk WHERE transaksi_masuk.id_barang = '$pencarian' UNION SELECT tgl_keluar AS tanggal, id_barang AS id_barang, id, jumlah, harga_keluar AS harga, total_harga, 'keluar' AS jenis_transaksi FROM transaksi_keluar WHERE transaksi_keluar.id_barang = '$pencarian' ORDER BY tanggal ASC");
    $query_sum_masuk = mysqli_query($con, "SELECT SUM(jumlah) AS total_qty, SUM(total_harga) AS total_akhir, harga_masuk FROM transaksi_masuk WHERE id_barang = '$pencarian'");
    $array_sum_masuk = mysqli_fetch_array($query_sum_masuk);
    $query_sum_keluar = mysqli_query($con, "SELECT SUM(jumlah) AS total_qty, SUM(total_harga) AS total_akhir, harga_keluar FROM transaksi_keluar WHERE id_barang = '$pencarian'");
    $array_sum_keluar = mysqli_fetch_array($query_sum_keluar);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a502a8bc22.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="shortcut icon" href="img/viking.png" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">

    <title>Invent Stack</title>
</head>

<body>

    <div class="top">

        <a href="#"><img class="icon-top" src="img/icon.jpg" alt="icon"></a>

        <div class="user-profile">
            <a href="#">
                <h4>admin</h4>
            </a>
            <a href="#"><img class="icon-user" src="img/viking.png"></a>
        </div>

    </div>

    <div class="nav-x-content">

        <nav class="link-nav-wrap">
            <div class="link-nav">
                <div>
                    <i class="fa-solid fa-house"></i>
                    <a href="dashboard.php">Dashboard</a>
                </div>
            </div>

            <div class="link-nav dropdown">
                <div>
                    <i class="fa-solid fa-layer-group"></i>
                    <h4>Master</h4>
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="sub-link-nav">
                <a href="pengguna.php">Pengguna</a>
                <a href="supplier.php">Supplier</a>
                <a href="barang.php">Barang</a>
                <a href="pelanggan.php">Pelanggan</a>
            </div>

            <div class="link-nav dropdown">
                <div>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h4>Transaksi</h4>
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="sub-link-nav">
                <a href="transaksi_masuk.php">Barang Masuk</a>
                <a href="transaksi_keluar.php">Barang Keluar</a>
            </div>

            <div class="link-nav dropdown">
                <div>
                    <i class="fa-solid fa-chart-line"></i>
                    <h4>Laporan</h4>
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="sub-link-nav">
                <a href="lap_transaksi_masuk.php">Lap. Barang Masuk</a>
                <a href="lap_transaksi_keluar.php">Lap. Barang Keluar</a>
                <a href="lap_persediaan.php">Lap. Persediaan Barang</a>
            </div>

            <div class="link-nav">
                <div>
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <a href="logout.php">Logout</a>
                </div>
            </div>

        </nav>

        <!-- </nav> -->

        <div class="content">

            <div class="h-content">
                <h3>Laporan Persediaan Barang</h3>
                <button onclick="window.location.href = 'cetak.php?cari=&barang=<?php if(isset($_GET['cari'])){echo $_GET['barang'];} ?>'" class="add-btn">Cetak <i class="fa-solid fa-print"></i></button>
            </div>

            <div id="table-wrap" class="table-wrap">
                <form method="get" class="custom-sort">
                    <select class="search-input" name="barang" id="barang" required>
                        <option value="" disabled selected>Select Barang</option>
                        <?php foreach ($query_barang as $key) { ?>
                            <option value="<?php echo $key['id']; ?>"><?php echo $key['nama_barang']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="cari" type="submit" class="btn-search-input">Cari</button>
                </form>
                <table id="good-table" class="good-table" cellspacing="0px">
                    <thead>
                        <tr>
                            <th rowspan="2">Tanggal</th>
                            <th rowspan="2">K. Transaksi</th>
                            <th colspan="3">Masuk</th>
                            <th colspan="3">Keluar</th>
                            <th colspan="3">Persediaan</th>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="list-good">
                        <?php if (isset($_GET['cari'])) {
                            foreach ($query_t_masuk as $key) { ?>
                                <?php if ($key["jenis_transaksi"] == "masuk") { ?>
                                    <?php
                                    $get_id_masuk = $key["kode_transaksi"];
                                    $query_sub_t_masuk = mysqli_query($con, "SELECT tgl_masuk AS tanggal, id_barang AS id_barang, id AS kode_transaksi, jumlah, harga_masuk AS harga, total_harga, 'masuk' AS jenis_transaksi FROM transaksi_masuk WHERE transaksi_masuk.id_barang = '$pencarian' AND id < '$get_id_masuk' ORDER BY tanggal ASC");
                                    foreach ($query_sub_t_masuk as $sub_key) { ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $sub_key["jumlah"]; ?></td>
                                            <td><?php echo number_format($sub_key["harga"], 0, ',', '.'); ?></td>
                                            <td><?php echo number_format($sub_key["total_harga"], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td><?php echo $key['tanggal']; ?></td>
                                        <td><?php echo "MSK_" . $key['kode_transaksi']; ?></td>
                                        <td><?php echo $key['jumlah']; ?></td>
                                        <td><?php echo number_format($key['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo number_format($key['total_harga'], 0, ',', '.'); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $key['jumlah']; ?></td>
                                        <td><?php echo number_format($key['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo number_format($key['total_harga'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php } else if ($key["jenis_transaksi"] == "keluar") { ?>
                                    <?php
                                    $get_id_masuk = $key["id_barang"];
                                    $j = 0;
                                    $query_sub_t_masuk = mysqli_query($con, "SELECT tgl_masuk AS tanggal, id_barang AS id_barang, id_t_masuk AS kode_transaksi, jumlah FROM sub_transaksi_masuk WHERE sub_transaksi_masuk.id_barang = '$pencarian' AND id_t_masuk <= '$get_id_masuk' ORDER BY tanggal ASC");
                                    foreach ($query_sub_t_masuk as $sub_key) {
                                        $j++; ?>
                                        <tr>
                                            <?php if ($j > 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $sub_key["jumlah"]; ?></td>
                                                <td><?php echo number_format($key["harga"], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($key["total_harga"], 0, ',', '.'); ?></td>
                                            <?php } else { ?>
                                                <td><?php echo $key["tanggal"]; ?></td>
                                                <td><?php echo "KLR_" . $key["kode_transaksi"]; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $key["jumlah"]; ?></td>
                                                <td><?php echo number_format($key["harga"], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($key["total_harga"], 0, ',', '.'); ?></td>
                                                <td><?php echo $sub_key["jumlah"]; ?></td>
                                                <td><?php echo number_format($key["harga"], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($key["total_harga"], 0, ',', '.'); ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <tr class="total">
                                <td class="" colspan="2">TOTAL</td>
                                <td><?php echo $array_sum_masuk["total_qty"]; ?></td>
                                <td></td>
                                <td><?php echo number_format($array_sum_masuk['total_akhir'], 0, ',', '.'); ?></td>
                                <td><?php echo $array_sum_keluar["total_qty"]; ?></td>
                                <td></td>
                                <td><?php echo number_format($array_sum_keluar['total_akhir'], 0, ',', '.'); ?></td>
                                <td><?php echo $array_sum_masuk["total_qty"] - $array_sum_keluar["total_qty"]; ?></td>
                                <td></td>
                                <td><?php echo number_format($array_sum_masuk["harga_masuk"]*($array_sum_masuk["total_qty"] - $array_sum_keluar["total_qty"]), 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- END of Nav Content -->
    </div>

    <script src="js/index.js"></script>
</body>

</html>