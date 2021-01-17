<?php
include_once("include/config.php");
require 'query_index.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RSA - Reminder Servis Application</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    include 'include/header.php';
    ?>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <!-- Check Data -->
    <!-- <pre>
    <?php
    print_r($arr3);
    ?>
    </pre> -->

    <div class="container mt-4">

        <!-- breadcumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Beranda</li>
            </ol>
        </nav>
        <!-- breadcumb -->

        <!-- tab header -->
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
        <!-- tab header -->

        <!-- tab content -->
        <div class="tab-content" id="myTabContent">
            <!-- incoming -->
            <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                <br>
                <table class="table is-bordered" id="tabel-data">
                    <thead>
                        <tr>
                            <th>Nama Pemilik</th>
                            <th>Telepon</th>
                            <th>No Polisi</th>
                            <th>Tanggal Servis Terakhir</th>
                            <th>Tanggal Servis Selanjutnya</th>
                            <th>Due</th>
                            <th>Booking Date</th>
                            <th>Servis Done</th>
                            <th>Booking Servis</th>
                            <th>Function</th>
                            <!-- <th>Detail Pelanggan</th>
                            <th>Whatsapp</th>
                             -->
                        </tr>
                    <tbody>
                        <?php
                        foreach ($arr as $user_data) {
                            // update tanggal servis selanjutnya
                            $today = new DateTime('now');
                            $next = (clone $today)->modify('+6 month');
                            // atur warna row
                            $highlight_css = "";
                            $button_css = "btn btn-info";
                            if ($user_data['due'] >= -3 && $user_data['due'] < 0) {
                                $highlight_css = "table-danger";
                                $button_css = "btn btn-danger";
                            } elseif ($user_data['due'] == 0) {
                                $highlight_css = "table-warning";
                                $button_css = "btn btn-info disabled";
                            }
                            // munculin data dalam row
                            echo "<tr class = '$highlight_css'>";
                            echo "<td>" . $user_data['nama'] . "</td>";
                            echo "<td>" . $user_data['telepon'] . "</td>";
                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                            echo "<td class='text-center'>" . $user_data['tglServisTerakhir'] . "</td>";
                            echo "<td class='text-center'>" . $user_data['tglServisSelanjutnya'] . "</td>";
                            echo "<td>" . $user_data['due'] . " Hari</td>";
                            // cek data booking
                            if (empty($arr3)) {
                                echo "<td class='text-center'> - </td>";
                                //echo "<td class='text-center'><input type='button' name='submit' class='btn btn-primary' value='Submit' id='submit' data-bs-toggle='modal' data-bs-target='#modal1" . $user_data['noRangka'] . "'></td>";
                                echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                            } else {
                                $counter = 0;
                                foreach ($arr3 as $book) {
                                    if ($book['noRangka'] == $user_data['noRangka']) {
                                        echo "<td class='text-center'>" . $book['tanggalServis'] . "</td>";
                                        //echo "<td class='text-center'><input type='button' name='submit' class='btn btn-primary' value='Submit' id='" . $user_data['noRangka'] . "' data-bs-toggle='modal' data-bs-target='#modal2" . $user_data['noRangka'] . "'></td>";
                                        echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                        $counter++;
                                    }
                                }
                                if($counter == 0){
                                    echo "<td class='text-center'> - </td>";
                                    //echo "<td class='text-center'><input type='button' name='submit' class='btn btn-primary' value='Submit' id='" . $user_data['noRangka'] . "' data-bs-toggle='modal' data-bs-target='#modal1" . $user_data['noRangka'] . "'></td>";
                                    echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                }
                            }
                            // echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                            // echo "<td><a href='https://wa.me/" . $user_data['telepon'] . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td>";
                            echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                            ?>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Function</button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="detail.php?id=<?php echo $user_data['id']."&noRangka=".$user_data['noRangka']; ?>">Detail</a></li>
                                        <li><a class="dropdown-item" href="edit.php?id=<?php echo $user_data['id']."&noRangka=".$user_data['noRangka']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
        </tbody>
        </table>
        <a href="insert.php" class='btn btn-success btn-sm' role='button'>+</a>
        </div>
        <!-- incoming content end -->

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
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            })
        });
    </script>
</body>

</html>