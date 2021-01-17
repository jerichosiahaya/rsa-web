<?php
include_once("include/config.php");
$noRangka = $_POST['noRangka'];
$jamBooking = $_POST['jamBooking'];
$tglServis = $_POST['tanggalServis'];
$sql = "update riwayat set riwayat.tanggalServis = '$tglServis', riwayat.jamBooking = '$jamBooking' where riwayat.noRangka = '$noRangka' and riwayat.done = 0 and riwayat.status = 2";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
    //echo ("Error description: " . $mysqli->error);
}
mysqli_close($conn);
