<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "hanzjoki";
$koneksi = mysqli_connect($server, $username, $password, $db);

if (mysqli_connect_error()) {
    echo "Koneksi gagal: " . mysqli_connect_error();
}


?>
