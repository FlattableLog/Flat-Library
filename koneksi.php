<?php

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "perpustakaan";

$koneksi = mysqli_connect($hostname, $username, $password, $databaseName);

if(!$koneksi) {
    echo "koneksi databse terputus";
    die("koneksi gagal");
}
?>