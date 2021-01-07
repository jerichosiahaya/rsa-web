<?php
include_once("config.php");
$result = mysqli_query($conn, "select pelanggan.id, mobil.noRangka, nama, noPolisi, tglServisTerakhir, tglServisSelanjutnya from pelanggan, mobil, detail_servis where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka ORDER BY tglServisSelanjutnya ASC");
date_default_timezone_set('Asia/Jayapura');
$date = date("Y-m-d");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reminder Servis Berkala</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">RSA</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insert.php" tabindex="-1">Tambah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">How to use</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><i><?php echo $date ?></i></a>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
        <table class="table is-bordered" id="tabel-data">
            <thead>
                <tr>
                    <th>Nama Pemilik</th>
                    <th>No Polisi</th>
                    <th>Tanggal Servis Terakhir</th>
                    <th>Tanggal Servis Selanjutnya</th>
                    <th>Due</th>
                    <th>Detail Pelanggan</th>
                    <th>Whatsapp</th>
                </tr>
            <tbody>
                <?php
                $noHp = '+6285244449300';
                while ($user_data = mysqli_fetch_array($result)) {
                    /*
                    $a = [];
                    $tglServisSelanjutnya = $user_data['tglServisSelanjutnya'];
                    //$tglServisSelanjutnya = $a;
                    echo json_encode($tglServisSelanjutnya);
                    foreach ((array) $tglServisSelanjutnya as $dueStr) {
                        $date1 = date_create($date);
                        $date2 = date_create($tglServisSelanjutnya);
                        $diff = date_diff($date1, $date2)->format("d-m-Y");
                        $highlight_css = "";
                        if ($diff > 1 && $diff <= 3) {
                            $highlight_css = "table-warning";
                        } elseif ($diff == 1) {
                            $highlight_css = "table-danger";
                        }
                        
                    } */
                    $date1 = date_create($date);
                    $date2 = date_create($user_data['tglServisSelanjutnya']);
                    $diff = date_diff($date2, $date1)->format("%r%a");
                    $highlight_css = "";
                    $button_css = "btn btn-info";
                    if ($diff >= -3 && $diff < 0) {
                        $highlight_css = "table-danger";
                        $button_css = "btn btn-danger";
                    } elseif ($diff == 0) {
                        $highlight_css = "table-warning";
                        $button_css = "btn btn-info disabled";
                    }
                    echo "<tr class = '$highlight_css'>";
                    echo "<td>" . $user_data['nama'] . "</td>";
                    echo "<td>" . $user_data['noPolisi'] . "</td>";
                    echo "<td>" . $user_data['tglServisTerakhir'] . "</td>";
                    echo "<td>" . $user_data['tglServisSelanjutnya'] . "</td>";
                    echo "<td>" . $diff . "Hari</td>";
                    echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                    echo "<td><a href='https://wa.me/" . $noHp . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td></tr>";
                    //<a href='https://wa.me/15551234567?text=I%20am%20interested%20in%20your%20services.%20How%20to%20get%20started%3F'>KIRIM</a>
                }
                //echo $diff;
                //echo $diff->format("%R%a days ");
                ?>
            </tbody>
        </table>
        <a href="insert.php" class='btn btn-success btn-sm' role='button'>TAMBAH</a>
        <!--<a href="add.php"><button class='button is-success is-rounded' style="margin-left: 32em" name='submit'><b>+</b></button></a>-->
    </div>

    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable();
        });
    </script>
</body>

</html>