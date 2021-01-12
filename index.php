<?php
include_once("config.php");
$result = mysqli_query(
    $conn, 
    "select pelanggan.id, mobil.noRangka, nama, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
    from pelanggan, mobil, detail_servis 
    where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka and TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) >= 0
    ORDER BY tglServisSelanjutnya ASC"
);

$res2 = mysqli_query(
    $conn, 
    "select pelanggan.id, mobil.noRangka, nama, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
    from pelanggan, mobil, detail_servis 
    where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka and TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) < 0
    ORDER BY tglServisSelanjutnya ASC"
);

date_default_timezone_set('Asia/Jayapura');

$arr = mysqli_fetch_all ($result, MYSQLI_ASSOC);
$arr2 = mysqli_fetch_all ($res2, MYSQLI_ASSOC);

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
    <!-- Check Data -->
    <!-- <pre>
    <?php
    print_r($arr2);
    ?>
    </pre> -->

    <?php include "navbar.php"?>

    <div class="container mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="incoming-tab" data-bs-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="true">Incoming</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="overdue-tab" data-bs-toggle="tab" href="#overdue" role="tab" aria-controls="overdue" aria-selected="false">Overdue</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="search-tab" data-bs-toggle="tab" href="#search" role="tab" aria-controls="search" aria-selected="false">Search</a>
            </li>
        </ul>
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav> -->

        <div class="tab-content" id="myTabContent">

            <!-- Incoming Content -->
            <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                <br>
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
                            <th>Booking Servis</th>
                        </tr>
                    <tbody>
                        <?php
                        $noHp = '+6285244449300';
                        foreach ($arr as $user_data) {
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
                            // $date1 = date_create($date);
                            // $date2 = date_create($user_data['tglServisSelanjutnya']);
                            // $diff = date_diff($date2, $date1)->format("%r%a");
                            $highlight_css = "";
                            $button_css = "btn btn-info";
                            if ($user_data['due'] >= -3 && $user_data['due'] < 0) {
                                $highlight_css = "table-danger";
                                $button_css = "btn btn-danger";
                            } elseif ($user_data['due'] == 0) {
                                $highlight_css = "table-warning";
                                $button_css = "btn btn-info disabled";
                            }
                            echo "<tr class = '$highlight_css'>";
                            echo "<td>" . $user_data['nama'] . "</td>";
                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                            echo "<td>" . $user_data['tglServisTerakhir'] . "</td>";
                            echo "<td>" . $user_data['tglServisSelanjutnya'] . "</td>";
                            echo "<td>" . $user_data['due'] . " Hari</td>";
                            echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                            echo "<td><a href='https://wa.me/" . $noHp . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td>";
                            echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>PESAN</a></tr>";
                            
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
            <!-- End Incoming Content -->
            
            <!-- Overdue Content -->
            <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                <br>
                <table class="table is-bordered" id="tabel-data2">
                    <thead>
                        <tr>
                            <th>Nama Pemilik</th>
                            <th>No Polisi</th>
                            <th>Tanggal Servis Terakhir</th>
                            <th>Tanggal Servis Selanjutnya</th>
                            <th>Due</th>
                            <th>Detail Pelanggan</th>
                            <th>Whatsapp</th>
                            <th>Booking Servis</th>
                        </tr>
                    <tbody>
                        <?php
                        $noHp = '+6285244449300';
                        //while ($user_data = mysqli_fetch_array($res2)) 
                        foreach ($arr2 as $user_data){
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
                            // $date1 = date_create($date);
                            // $date2 = date_create($user_data['tglServisSelanjutnya']);
                            // $diff = date_diff($date2, $date1)->format("%r%a");
                            $highlight_css = "";
                            $button_css = "btn btn-info";
                            if ($user_data['due'] >= -3 && $user_data['due'] < 0) {
                                $highlight_css = "table-danger";
                                $button_css = "btn btn-danger";
                            } elseif ($user_data['due'] == 0) {
                                $highlight_css = "table-warning";
                                $button_css = "btn btn-info disabled";
                            }
                            echo "<tr class = '$highlight_css'>";
                            echo "<td>" . $user_data['nama'] . "</td>";
                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                            echo "<td>" . $user_data['tglServisTerakhir'] . "</td>";
                            echo "<td>" . $user_data['tglServisSelanjutnya'] . "</td>";
                            echo "<td>" . $user_data['due'] . "Hari</td>";
                            echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                            echo "<td><a href='https://wa.me/" . $noHp . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td>";
                            echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>SERVIS</a></td></tr>";
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
            <!-- End Overdue Content -->

            <!-- Search Content -->
            <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">
                <br>
                <div class='container pt-5'>
                    <h1>Search Due</h1>
                    <div class="row">
                        <div class="col-sm-12">
                            <form method='post' action="<?php echo $_SERVER['PHP_SELF'];?>#search" class="pt-5">
                                <div class='form-group row'>
                                    <label class='col-sm-3' for='days'>Days: </label>
                                    <div class='col-sm-6'><input class='form-control' type='number' name='days' placeholder = "Sisa Hari..." required></div>
                                </div>
                                <button type='submit' name='submit' class='btn btn-primary' role='button'>Search</a>
                            </form>
                        </div>
                    </div>
                    <?php
                    if(isset($_POST['submit'])){
                        //echo("Days: " . $_POST['days'] . "<br>");
                        $id = $_POST['days'];
                        $result3 = mysqli_query(
                            $conn, 
                            "select pelanggan.id, mobil.noRangka, nama, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
                            from pelanggan, mobil, detail_servis 
                            where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka and TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) = $id
                            ORDER BY tglServisSelanjutnya ASC"
                        );
                        $arr3 = mysqli_fetch_all ($result3, MYSQLI_ASSOC);
                    ?>
                    <br>
                    <table class="table is-bordered" id="tabel-data3">
                        <thead>
                            <tr>
                                <th>Nama Pemilik</th>
                                <th>No Polisi</th>
                                <th>Tanggal Servis Terakhir</th>
                                <th>Tanggal Servis Selanjutnya</th>
                                <th>Due</th>
                                <th>Detail Pelanggan</th>
                                <th>Whatsapp</th>
                                <th>Booking Servis</th>
                            </tr>
                        <tbody>
                            <?php
                            $noHp = '+6285244449300';
                            foreach ($arr3 as $user_data) {
                                $highlight_css = "";
                                $button_css = "btn btn-info";
                                if ($user_data['due'] >= -3 && $user_data['due'] < 0) {
                                    $highlight_css = "table-danger";
                                    $button_css = "btn btn-danger";
                                } elseif ($user_data['due'] == 0) {
                                    $highlight_css = "table-warning";
                                    $button_css = "btn btn-info disabled";
                                }
                                echo "< class = '$highlight_css'>";
                                echo "<td>" . $user_data['nama'] . "</td>";
                                echo "<td>" . $user_data['noPolisi'] . "</td>";
                                echo "<td>" . $user_data['tglServisTerakhir'] . "</td>";
                                echo "<td>" . $user_data['tglServisSelanjutnya'] . "</td>";
                                echo "<td>" . $user_data['due'] . " Hari</td>";
                                echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                                echo "<td><a href='https://wa.me/" . $noHp . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td>";
                                echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>PESAN</a></td></tr>";
                                //<a href='https://wa.me/15551234567?text=I%20am%20interested%20in%20your%20services.%20How%20to%20get%20started%3F'>KIRIM</a>
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="insert.php" class='btn btn-success btn-sm' role='button'>TAMBAH</a>

                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- End Search Content -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable({
                "ordering": false
            });
            $('#tabel-data2').DataTable({
                "ordering": false
            });
            $('#tabel-data3').DataTable({
                "ordering": false
            });
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            } 

            // Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            })
        });
    </script>
</body>

</html>