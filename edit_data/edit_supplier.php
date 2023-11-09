<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

include "../php/func.php";

$get_id = $_GET['id'];
$query_data = mysqli_query($con, "SELECT * FROM supplier WHERE id = '$get_id'");
$array_data = mysqli_fetch_array($query_data);

if (isset($_POST["edit"])) {
    if (editSupplier($_POST) > 0) {
        echo "<script>alert('Berhasil mengedit supplier!');window.location = '../supplier.php';</script>";
    } else {
        echo "<script>alert('Edit supplier dibatalkan');window.location = '../supplier.php';</script>";
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
    <title>Edit Supplier</title>
</head>

<body>

    <!-- FORM EDIT -->
    <div class="modal-form" id="form-edit-wrap">
        <form method="post" class="form-edit" id="form-edit">
            <a href="../supplier.php" class="close-icon" id="close-icon-edit">&times;</a>
            <h3>Edit Supplier</h3>
            <div class="input-div">
                <input name="id" type="hidden" value="<?php echo $array_data["id"]; ?>">

                <label for="nama">Nama Supplier</label>
                <input value="<?php echo $array_data["nama_supplier"]; ?>" class="" type="text" name="nama" required><br>

                <label for="alamat">Alamat</label>
                <input value="<?php echo $array_data["alamat"]; ?>" class="" type="text" name="alamat" required><br>

                <label for="email">Email</label>
                <input value="<?php echo $array_data["email_supplier"]; ?>" class="" type="email" name="email" required><br>

                <label for="telp">No. Telp</label>
                <input value="<?php echo $array_data["no_telp"]; ?>" class="" type="number" name="telp" min="1" required><br>

                <button type="submit" name="edit" class="btn-add-form">Edit</button>
            </div>

        </form>
    </div>
    <!-- END FORM EDIT -->

</body>

</html>