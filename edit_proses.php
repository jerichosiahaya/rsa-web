<?php
include_once("config.php");
//$tglServisTerakhir = date("Y-m-d", strtotime($st));
//$tglServisSelanjutnya = date("Y-m-d", strtotime($sl));
$a = $_POST['st'];
$b = $_POST['sl'];
$c = $_POST['nr'];
$sql = "update detail_servis 
set tglServisTerakhir = '$a', 
tglServisSelanjutnya = '$b' 
where noRangka = '$c'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);
