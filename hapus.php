<?php

include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT sampul, ebook FROM buku WHERE id = '$id'");
$row = mysqli_fetch_assoc($data);

if(!empty($row['sampul']) && file_exists("asset/sampul/" . $row['sampul'])){
    unlink(
        "asset/sampul/" . $row['sampul']
    );
}

if(!empty($row['ebook']) && file_exists("asset/ebook/" . $row['ebook'])){
    unlink(
        "asset/ebook/" . $row['ebook']
    );
}

mysqli_query($koneksi, "DELETE FROM buku WHERE id = '$id'");
header("location:daftarBuku.php");
?>