<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: index.php");
    exit();
}

include "../php/func.php";

$get_id = $_GET["id"];
$query = mysqli_query($con, "DELETE FROM pelanggan WHERE id = '$get_id'");

header("Location: ../pelanggan.php");
exit();

?>