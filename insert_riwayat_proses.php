<?php
include_once("include/config.php");
$nama = $_POST['nama'];
$telepon = $_POST['telepon'];
$noRangka = $_POST['noRangka'];
$jamBooking = $_POST['jamBooking'];
$status = $_POST['status'];
$done = $_POST['done'];
$kilometer = $_POST['kilometer'];
$tglServis = $_POST['tanggalServis'];
$tglServisSelanjutnya = $_POST['tanggalServisSelanjutnya'];
$sql1 = "insert into riwayat (noRangka, tanggalServis, kilometer, namaBooking, noTeleponBooking, jamBooking, status, done) values ('$noRangka', '$tglServis', $kilometer, '$nama', '$telepon', '$jamBooking', $status, $done)";
$sql2 = "update detail_servis set detail_servis.tglServisTerakhir = '$tglServis', detail_servis.tglServisSelanjutnya = '$tglServisSelanjutnya', kilometer = $kilometer where noRangka = '$noRangka'";
if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
    //echo ("Error description: " . $mysqli->error);
}
mysqli_close($conn);
