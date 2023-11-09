<?php

include 'php/func.php';

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
    <link rel="stylesheet" href="css/index.css">
    <script
			src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
			integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer"></script>
    <title>Print</title>
</head>
<body>

<div id="good-table">
    <h3 style="text-align: center;margin-bottom: 10px;">Laporan Persediaan Barang</h3>
<table class="good-table" cellspacing="0px">
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
    <script src="js/cetak_pdf.js"></script>
</body>
</html>