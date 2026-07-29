<?php

include 'koneksi.php';

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if($aksi == 'tambah'){
    mysqli_query(
        $koneksi, "UPDATE buku SET
        jumlah = jumlah + 1
        WHERE id = '$id'"
    );
}elseif($aksi == 'kurang'){
    mysqli_query(
        $koneksi, "UPDATE buku SET
        jumlah = jumlah - 1
        WHERE id = '$id'
        AND jumlah > 0"
    );
}
header("location:daftarBuku.php");
exit;
?>