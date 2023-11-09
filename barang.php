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

$query_supplier = mysqli_query($con, "SELECT * FROM supplier");

if (isset($_POST['tambah'])) {
    if (addBarang($_POST) > 0) {
        echo "<script>alert('Berhasil menambah barang!');window.location = 'barang.php';</script>";
    } else {
        echo "<script>alert('Oops! gagal menambah barang :(');</script>";
    }
}

if(isset($_GET['cari'])){
    $pencarian = $_GET['barang'];
    $query_barang = mysqli_query($con, "SELECT * FROM barang WHERE nama_barang LIKE '%$pencarian%'");
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
                <h3>Barang</h3>
                <button id="add-btn" class="add-btn">Add <i class="fa-solid fa-plus"></i></button>
            </div>

            <div class="table-wrap">
                <form method="get" class="custom-sort">
                    <input name="barang" id="search-good" class="search-input" placeholder="Cari Barang" type="text">
                    <button name="cari" type="submit" class="btn-search-input">Cari</button>
                </form>
                <table class="good-table" cellspacing="0px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Harga Masuk</th>
                            <th>Harga Keluar</th>
                            <th>Stock</th>
                            <th>Supplier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-good">
                        <?php $i = 1;
                        foreach ($query_barang as $key) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo "BRG_" . $key['id']; ?></td>
                                <td><?php echo $key['nama_barang']; ?></td>
                                <td><?php echo $key['satuan']; ?></td>
                                <td><?php echo number_format($key['harga_masuk'], 0, ',', '.'); ?></td>
                                <td><?php echo number_format($key['harga_keluar'], 0, ',', '.'); ?></td>
                                <td><?php echo $key['stock']; ?></td>
                                <td><?php echo $key['supplier']; ?></td>
                                <td><a href='edit_data/edit_barang.php?id=<?php echo $key['id']; ?>' id="edit-btn"><i class='fa-regular fa-pen-to-square'></i></a> <a href='edit_data/delete_barang.php?id=<?php echo $key['id']; ?>'><i class='fa-regular fa-trash-can'></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- END of Nav Content -->
    </div>

    <!-- FORM ADD -->
    <div class="modal-form" id="form-add-wrap">
        <form method="post" class="form-add" id="form-add">
            <span class="close-icon" id="close-icon-add">&times;</span>
            <h3>Tambah Barang</h3>
            <div class="input-div">

                <label for="nama">Nama Barang</label>
                <input class="" type="text" name="nama" required><br>

                <label for="satuan">Satuan</label>
                <input class="not_allow" type="text" value="pcs" name="satuan" id="satuan" required readonly><br>

                <label for="harga_masuk">Harga Masuk</label>
                <input class="" oninput="harga_barang(this.value)" type="number" name="harga_masuk" id="harga_masuk" required><br>

                <label for="harga_keluar">Harga Keluar</label>
                <input class="not_allow" type="number" step="0.01" name="harga_keluar" id="harga_keluar" required readonly><br>

                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" required>
                    <option value="" disabled selected>Select Supplier</option>
                    <?php foreach ($query_supplier as $key) { ?>
                        <option value="<?php echo $key['nama_supplier']; ?>"><?php echo $key['nama_supplier']; ?></option>
                    <?php } ?>
                </select><br>

                <button name="tambah" type="submit" class="btn-add-form">Tambah</button>
            </div>

        </form>
    </div>
    <!-- END FORM ADD -->



    <!-- AJAX -->
    <!-- <script src="js/ajax-good.js"></script> -->
    <script src="js/index.js"></script>
    <script>
        function harga_barang(h_masuk) {
            var harga = parseFloat(h_masuk);
            document.getElementById("harga_keluar").value = harga + (harga * 0.08);
        };
    </script>
</body>

</html>