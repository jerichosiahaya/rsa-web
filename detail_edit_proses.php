<?php
include_once("config.php");
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$id = $_POST['id'];
$sql = "update pelanggan set nama = '$nama', 
alamat = '$alamat',
telepon = $telepon
where id = $id";
//update pelanggan set nama = 'Jericho Sia', alamat = 'Jln. Yabansai No 2 Perumnas 1 Waena', telepon = 82238463057 where id = 2
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);
