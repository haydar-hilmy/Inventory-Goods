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

$query_t_keluar = mysqli_query($con, "SELECT * FROM transaksi_keluar");


if (isset($_GET['cari'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $query_t_keluar = mysqli_query($con, "SELECT * FROM transaksi_keluar WHERE tgl_keluar >= '$dari' AND tgl_keluar <= '$sampai'");
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="img/viking.png" type="image/x-icon">

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
                <h3>Laporan Transaksi Barang Keluar</h3>
            </div>

            <div class="table-wrap">
                <form method="get" class="custom-sort">
                    <input required name="dari" id="search-good" class="search-input" type="date">
                    <label>Sampai</label>
                    <input required name="sampai" id="search-good" class="search-input" type="date">
                    <button name="cari" type="submit" class="btn-search-input">Tampilkan</button>
                </form>
                <table class="good-table" cellspacing="0px">
                    <?php if(isset($_GET['cari'])){ ?>
                    <h4>Data barang keluar tanggal <?php echo $_GET['dari'] ?> - <?php echo $_GET['sampai'] ?></h4><br>
                    <?php } ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Satuan</th>
                            <th>Kode Pelanggan</th>
                            <th>Pelanggan</th>
                            <th>Harga Keluar</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="list-good">
                        <?php $i = 1;
                        foreach ($query_t_keluar as $key) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo "TRK_" . $key['id']; ?></td>
                                <td><?php echo $key['tgl_keluar']; ?></td>
                                <td><?php echo "BRG_" . $key['id_barang']; ?></td>
                                <td><?php echo $key['nama_barang']; ?></td>
                                <td><?php echo $key['satuan']; ?></td>
                                <td><?php echo "SPL_" . $key['id_pelanggan']; ?></td>
                                <td><?php echo $key['nama_pelanggan']; ?></td>
                                <td><?php echo number_format($key['harga_keluar'], 0, ',', '.'); ?></td>
                                <td><?php echo $key['jumlah']; ?></td>
                                <td><?php echo number_format($key['total_harga'], 0, ',', '.'); ?></td>
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