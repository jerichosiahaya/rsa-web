<?php
include_once("config.php");
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$noRangka = $_POST['noRangka'];
$noPolisi = $_POST['noPolisi'];
$noMesin = $_POST['noMesin'];
$kilometer = $_POST['kilometer'];
$tglBeli = $_POST['tglBeli'];
$tglServisTerakhir = $_POST['tglServisTerakhir'];
$tglServisSelanjutnya = $_POST['tglServisSelanjutnya'];
$sql1 = "insert into pelanggan (nama, alamat, telepon) values ('$nama', '$alamat', '$telepon')";
$sql2 = "insert into mobil (noRangka, noPolisi, tglBeli) values ('$noMesin','$noRangka', '$noPolisi', '$tglBeli')";
$sql3 = "insert into detail_servis (kilometer, tglServisTerakhir, tglServisSelanjutnya, noRangka) values ($kilometer,'$tglServisTerakhir', '$tglServisSelanjutnya', '$noRangka')";
//update pelanggan set nama = 'Jericho Sia', alamat = 'Jln. Yabansai No 2 Perumnas 1 Waena', telepon = 82238463057 where id = 2
if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);
