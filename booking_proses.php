<?php
include_once("config.php");

$namaBooking = $_POST['namaBooking'];
$noTeleponBooking = $_POST['noTeleponBooking'];
$tanggalServis= $_POST['tanggalServis'];
$jamBooking= $_POST['jamBooking'];
$noRangka = $_POST['noRangka'];

$sql1 = "INSERT INTO riwayat (noRangka, tanggalServis, kilometer, namaBooking, noTeleponBooking, jamBooking, status) 
VALUES ('$noRangka', '$tanggalServis', NULL, '$namaBooking', '$noTeleponBooking', '$jamBooking', 2)";
if (mysqli_query($conn, $sql1)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);
?>


