<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: index.php");
    exit();
}

include "../php/func.php";

$get_id = $_GET['id'];
$query_data = mysqli_query($con, "SELECT * FROM master WHERE id = '$get_id'");
$array_data = mysqli_fetch_array($query_data);

if(isset($_POST["edit"])){
    if(editPengguna($_POST) > 0){
        echo "<script>alert('Berhasil mengedit pengguna!');window.location = '../pengguna.php';</script>";
    } else {
        echo "<script>alert('Edit pengguna dibatalkan');window.location = '../pengguna.php';</script>";
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
    <title>Edit Pengguna</title>
</head>
<body>

    <!-- FORM EDIT -->
    <div class="modal-form" id="form-edit-wrap">
        <form method="post" class="form-edit" id="form-edit">
            <a href="../pengguna.php" class="close-icon" id="close-icon-edit">&times;</a>
            <h3>Edit Pengguna</h3>
            <div class="input-div">
                <input type="hidden" name="id" value="<?php echo $array_data["id"]; ?>">

                <label for="nama">Nama Pengguna</label>
                <input value="<?php echo $array_data["nama_pengguna"]; ?>" class="" type="text" name="nama" required><br>

                <label for="email">Email</label>
                <input value="<?php echo $array_data["email"]; ?>" class="" type="text" name="email" required><br>

                <label for="jabatan">Jabatan</label>
                <input value="<?php echo $array_data["jabatan"]; ?>" class="" type="text" name="jabatan" required><br>

                <label for="password">Password</label>
                <input value="<?php echo $array_data["kata_sandi"]; ?>" class="" type="password" name="password" required><br>

                <button name="edit" type="submit" class="btn-add-form">Edit</button>
            </div>

        </form>
    </div>
    <!-- END FORM EDIT -->
    
</body>
</html>