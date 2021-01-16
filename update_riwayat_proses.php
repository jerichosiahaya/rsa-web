<?php
include_once("include/config.php");
$noRangka = $_POST['noRangka'];
$status = $_POST['status'];
$done = $_POST['done'];
$kilometer = $_POST['kilometer'];
$tglServis = $_POST['tanggalServis'];
$tglServisSelanjutnya = $_POST['tanggalServisSelanjutnya'];
$sql1 = "update riwayat set riwayat.kilometer = $kilometer, riwayat.done = $done where riwayat.noRangka = '$noRangka' and riwayat.status = $status and riwayat.tanggalServis = '$tglServis'";
$sql2 = "update detail_servis set detail_servis.tglServisTerakhir = '$tglServis', detail_servis.tglServisSelanjutnya = '$tglServisSelanjutnya', kilometer = $kilometer where noRangka = '$noRangka'";
if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
    //echo ("Error description: " . $mysqli->error);
}
mysqli_close($conn);
