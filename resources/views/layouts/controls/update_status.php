<?php
include "../../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    //Reset semua status menjadi 0
    $resetStatus = "UPDATE intro SET status = 0";
    mysqli_query($koneksi, $resetStatus);

    //Set status uyang dipilih menjadi 1
    $updateStatus = "UPDATE intro SET status = 1 WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $updateStatus);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Status Update Sukses :)";
    } else {
        echo "Gagal coba lagi jangan manja";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
}
