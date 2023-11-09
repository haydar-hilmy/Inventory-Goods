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

$query_supplier = mysqli_query($con, "SELECT * FROM supplier");
$query_barang = mysqli_query($con, "SELECT * FROM barang");
$query_pelanggan = mysqli_query($con, "SELECT * FROM pelanggan");
$query_transaksi = mysqli_query($con, "SELECT * FROM transaksi_masuk UNION SELECT * FROM transaksi_keluar");
$total_barang = mysqli_num_rows($query_barang);
$total_supplier = mysqli_num_rows($query_supplier);
$total_pelanggan = mysqli_num_rows($query_pelanggan);
$total_transaksi = mysqli_num_rows($query_transaksi);


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
                <h4><?php echo $array_data['nama_pengguna']; ?></h4>
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
                <h3>Dashboard</h3>
            </div>

            <div class="table-wrap">
                <div class="icon-dashboard-wrap">
                    <div class="icon-dashboard">
                        <h3><?php echo $total_transaksi; ?></h3>
                        <h4>Transaksi</h4>
                    </div>
                    <div class="icon-dashboard">
                        <h3><?php echo $total_barang; ?></h3>
                        <h4>Barang</h4>
                    </div>
                    <div class="icon-dashboard">
                        <h3><?php echo $total_pelanggan; ?></h3>
                        <h4>Pelanggan</h4>
                    </div>
                    <div class="icon-dashboard">
                        <h3><?php echo $total_supplier; ?></h3>
                        <h4>Supplier</h4>
                    </div>
                </div>
            </div>

        </div>

        <!-- END of Nav Content -->
    </div>

    <!-- AJAX -->
    <!-- <script src="js/ajax-good.js"></script> -->
    <script src="js/index.js"></script>
</body>

</html>