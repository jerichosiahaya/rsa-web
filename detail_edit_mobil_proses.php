<?php
include_once("include/config.php");

$noRangka = $_POST['noRangka'];
$model = $_POST['model'];
$noMesin = $_POST['noMesin'];
$noPolisi = $_POST['noPolisi'];
$deliveryDate = $_POST['deliveryDate'];
$id = $_POST['id'];


$sql = "update mobil set noMesin = '$noMesin',
model = '$model',
noPolisi = '$noPolisi',
deliveryDate = '$deliveryDate',
id = '$id'
where noRangka = '$noRangka'";

//update pelanggan set nama = 'Jericho Sia', alamat = 'Jln. Yabansai No 2 Perumnas 1 Waena', telepon = 82238463057 where id = 2
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);
