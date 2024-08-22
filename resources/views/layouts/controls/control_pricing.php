<?php
include "../../config/connection.php";

if (isset($_GET['ctrl']) && $_GET['ctrl'] == "edt") {
    if (isset($_POST['edit'])) {
        $id = $_GET['idctrl'];
        $id_intro = $_POST['id_intro'];
        $pilihedisi = $_POST['pilihedisi'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        $card_class = $_POST['card_class'];
        $header = $_POST['header'];
        $subtitle = $_POST['subtitle'];
        $btn_class = $_POST['btn_class'];

        $queryUpdate = mysqli_query($koneksi, "UPDATE pricing SET id_intro = $id_intro, pilihedisi = '$pilihedisi', harga = $harga, deskripsi = '$deskripsi', card_class = '$card_class', header = '$header', subtitle = '$subtitle', btn_class = '$btn_class', updated_at= now() WHERE id = $id");
        if ($queryUpdate) {
            header("location: ../index.php?page=pricing");
            exit;
        }
    }
} elseif (isset($_GET['ctrl']) && $_GET['ctrl'] == "pricingdelete") {
    $id = base64_decode($_GET['id']);

    //Delete Permanen
    //DELETE FROM pricing WHERE id = $id

    //DELETE Soft
    //UPDATE pricing SET deleted_at = now() WHERE id = $id

    $queryDelete = mysqli_query($koneksi, "UPDATE pricing SET deleted_at = now() WHERE id = $id");
    if ($queryDelete) {
        header("Location: ../index.php?page=pricing");
    }
} elseif (isset($_GET['ctrl']) && $_GET['ctrl'] == 'addpricing') {
    if (isset($_POST['simpan'])) {
        $countDisplay = $_POST['countDisplay'];
    }
    for ($i = 0; $i < $countDisplay; $i++) {
        $idIntr = htmlspecialchars($_POST['idIntr'][$i]);
        $edisi = htmlspecialchars($_POST['edisi'][$i]);
        $harga = htmlspecialchars($_POST['harga'][$i]);
        $deskripsi = htmlspecialchars($_POST['deskripsi'][$i]);
        $card_class = htmlspecialchars($_POST['card_class'][$i]);
        $header = htmlspecialchars($_POST['header'][$i]);
        $subtitle = htmlspecialchars($_POST['subtitle'][$i]);
        $btn_class = htmlspecialchars($_POST['btn_class'][$i]);

        $insertPricing = mysqli_prepare($koneksi, "INSERT INTO pricing (id_intro, pilihedisi, harga, deskripsi, card_class, header, subtitle, btn_class,created_at) VALUES ($idIntr, '$edisi', '$harga','$deskripsi','$card_class','$header','$subtitle','$btn_class',now())");
        mysqli_stmt_execute($insertPricing);

        if (mysqli_stmt_affected_rows($insertPricing) > 0) {
            continue;
        } else {
            echo "Error" . mysqli_errno($koneksi);
            exit;
        }
    }
    if ($insertPricing) {
        header("Location: ../index.php?page=pricing");
        exit;
    }
}
