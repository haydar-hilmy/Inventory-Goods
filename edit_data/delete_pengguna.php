<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: index.php");
    exit();
}

include "../php/func.php";

$get_id = $_GET["id"];
$query = mysqli_query($con, "DELETE FROM master WHERE id = '$get_id'");

header("Location: ../pengguna.php");
exit();

?>