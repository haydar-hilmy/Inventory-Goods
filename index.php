<?php
session_start();

include 'php/func.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekdata = mysqli_query($con, "SELECT * FROM master WHERE nama_pengguna = '$username'");

    if(mysqli_num_rows($cekdata) === 1){

        $array = mysqli_fetch_assoc($cekdata);

        if($password == $array['kata_sandi']){
            $_SESSION['login'] = true;
            $_SESSION['login'] = $username;
            header("Location: dashboard.php");
            exit;
        }
    }    

$salah_password = true;

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
    <link rel="stylesheet" href="css/login.css">
    <title>Invent Stack - Login</title>
</head>

<body>

    <div class="form-wrap">
        <h2>Selamat datang kembali! Silakan login</h2>
        <p>Persediaan Barang Metode FIFO</p>
        <form method="post" action="">
            <div>
                <label for="username"><i class="fa fa-user-circle"></i></label>
                <input type="username" id="username" placeholder="Nama Pengguna" name="username" required autofocus>
            </div><br>

            <div>
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" id="password" placeholder="Password" name="password" required autofocus>
            </div><br>

            <?php
            if(isset($salah_password)){
                echo "<p class='wrong-pass'>username atau password tidak ditemukan</p>";
            }
            ?>

            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
    </div>

</body>

</html>