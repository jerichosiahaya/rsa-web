<?php
include_once("include/config.php");
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$noRangka = $_POST['noRangka'];
$noPolisi = $_POST['noPolisi'];
$model = $_POST['model'];
$noMesin = $_POST['noMesin'];
$kilometer = $_POST['kilometer'];
$tglBeli = $_POST['tglBeli'];
$tglServisTerakhir = $_POST['tglServisTerakhir'];
$tglServisSelanjutnya = $_POST['tglServisSelanjutnya'];

$check_mobil = mysqli_query($conn, "select noRangka from mobil where noRangka='$noRangka'");
$ckm = mysqli_fetch_all($check_mobil, MYSQLI_ASSOC);
if (!isset($ckm[0]['noRangka'])) {
    $check = mysqli_query(
        $conn,
        "select id from pelanggan where nama = '$nama' and telepon = '$telepon'"
    );
    $id = mysqli_fetch_all($check, MYSQLI_ASSOC);



    if (isset($id[0]['id'])) {
        $sql2 = "insert into mobil (noRangka, noMesin, model, noPolisi, deliveryDate, id) values ('$noRangka', '$noMesin', '$model', '$noPolisi', '$tglBeli', " . $id[0]['id'] . ")";
        $sql3 = "insert into detail_servis (kilometer, tglServisTerakhir, tglServisSelanjutnya, noRangka) values ($kilometer,'$tglServisTerakhir', '$tglServisSelanjutnya', '$noRangka')";
        if (mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    } else {
        $sql1 = "insert into pelanggan (nama, alamat, telepon) values ('$nama', '$alamat', '$telepon')";

        $try = mysqli_query($conn, $sql1);

        $check2 = mysqli_query(
            $conn,
            "select id from pelanggan where nama = '$nama'"
        );
        $id2 = mysqli_fetch_all($check2, MYSQLI_ASSOC);
        $sql2 = "insert into mobil (noRangka, noMesin, model, noPolisi, deliveryDate, id) values ('$noRangka', '$noMesin', '$model', '$noPolisi', '$tglBeli', " . $id2[0]['id'] . ")";
        $sql3 = "insert into detail_servis (kilometer, tglServisTerakhir, tglServisSelanjutnya, noRangka) values ($kilometer,'$tglServisTerakhir', '$tglServisSelanjutnya', '$noRangka')";
        if (mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3) && $try == 1) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }
} else {
    echo json_encode(array("statusCode" => 202));
}





// if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
//     echo json_encode(array("statusCode" => 200));
// } else {
//     echo json_encode(array("statusCode" => 201));
// }
mysqli_close($conn);


// $sql2 = "insert into mobil (noMesin, noRangka, noPolisi, deliveryDate) values ('$noMesin','$noRangka', '$noPolisi', '$tglBeli')";
// $sql3 = "insert into detail_servis (kilometer, tglServisTerakhir, tglServisSelanjutnya, noRangka) values ($kilometer,'$tglServisTerakhir', '$tglServisSelanjutnya', '$noRangka')";
//update pelanggan set nama = 'Jericho Sia', alamat = 'Jln. Yabansai No 2 Perumnas 1 Waena', telepon = 82238463057 where id = 2