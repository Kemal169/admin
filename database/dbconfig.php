<?php

$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "adminpanel";

$connection = mysqli_connect($server_name,$db_username,$db_password,$db_name);

if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>