<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

include "../php/func.php";

$get_id = $_GET['id'];
$query_data = mysqli_query($con, "SELECT * FROM barang WHERE id = '$get_id'");
$array_data = mysqli_fetch_array($query_data);

$query_supplier = mysqli_query($con, "SELECT * FROM supplier");

if (isset($_POST["edit"])) {
    if (editBarang($_POST) > 0) {
        echo "<script>alert('Berhasil mengedit barang!');window.location = '../barang.php';</script>";
    } else {
        echo "<script>alert('Edit barang dibatalkan');window.location = '../barang.php';</script>";
    }
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
    <link rel="stylesheet" href="../css/index.css">
    <title>Edit Barang</title>
</head>

<body>

    <!-- FORM EDIT -->
    <div class="modal-form" id="form-edit-wrap">
        <form method="post" class="form-edit" id="form-edit">
            <a href="../barang.php" class="close-icon" id="close-icon-edit">&times;</a>
            <h3>Edit Barang</h3>
            <div class="input-div">
                <input type="hidden" name="id" value="<?php echo $array_data["id"]; ?>">

                <label for="kode">Kode Barang</label>
                <input class="not_allow" type="text" value="<?php echo "BRG_" . $array_data["id"]; ?>" name="kode" id="kode" readonly required><br>

                <label for="nama">Nama Barang</label>
                <input value="<?php echo $array_data["nama_barang"]; ?>" class="" type="text" name="nama" required><br>

                <label for="satuan">Satuan</label>
                <input class="not_allow" type="text" value="<?php echo $array_data["satuan"]; ?>" name="satuan" id="satuan" required readonly><br>

                <label for="harga_masuk">Harga Masuk</label>
                <input oninput="harga_barang(this.value)" value="<?php echo $array_data["harga_masuk"]; ?>" class="" type="number" name="harga_masuk" required><br>

                <label for="harga_keluar">Harga Keluar</label>
                <input value="<?php echo $array_data["harga_keluar"]; ?>" id="harga_keluar" class="not_allow" type="number" step="0.01" name="harga_keluar" required readonly><br>

                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" required>
                    <option value="" disabled selected>Select Supplier</option>
                    <?php foreach ($query_supplier as $key) { ?>
                        <?php if ($key['nama_supplier'] == $array_data["supplier"]) { ?>
                            <option value="<?php echo $key['nama_supplier']; ?>" selected><?php echo $key['nama_supplier']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key['nama_supplier']; ?>"><?php echo $key['nama_supplier']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select><br>

                <button type="submit" name="edit" class="btn-add-form">Edit</button>
            </div>

        </form>
    </div>
    <!-- END FORM EDIT -->

    <script>
        function harga_barang(h_masuk) {
            var harga = parseFloat(h_masuk);
            document.getElementById("harga_keluar").value = harga + (harga * 0.08);
        };
    </script>
</body>

</html>