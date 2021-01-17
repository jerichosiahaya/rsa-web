<?php
include_once("include/config.php");
global $id, $noRangka;
$id = $_GET['id'];
$noRangka = $_GET['noRangka'];

$result_riwayat_ongoing = mysqli_query($conn, 
"select idRiwayatBooking, noRangka, tanggalServis, kilometer, namaBooking, noTeleponBooking, jamBooking, status, done 
from riwayat where riwayat.noRangka = '$noRangka' AND done = 0 ORDER BY tanggalServis ASC");

$result_riwayat_done = mysqli_query($conn, 
"select idRiwayatBooking, noRangka, tanggalServis, kilometer, namaBooking, noTeleponBooking, jamBooking, status, done 
from riwayat where riwayat.noRangka = '$noRangka' AND done = 1 ORDER BY tanggalServis ASC");

/*
$result_detail = mysqli_query($conn, 
"select idRiwayatBooking, noRangka, tanggalServis, kilometer, namaBooking, noTeleponBooking, jamBooking, status, done 
from riwayat where riwayat.noRangka = '$noRangka' AND idRiwayatBooking = '$idRiwayatBooking'");*/

$arr1 = mysqli_fetch_all ($result_riwayat_ongoing, MYSQLI_ASSOC);
$arr2 = mysqli_fetch_all ($result_riwayat_done, MYSQLI_ASSOC);
//$arr3 = mysqli_fetch_all ($result_detail. MYSQLI_ASSOC);
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'include/header.php'; ?>
</head>

<body>

    <?php include 'include/navbar.php'; ?>



    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><?php echo "<a href='detail.php?id=$id&noRangka=$noRangka'"?>>Detail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Servis</li>
            </ol>
        </nav>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="ongoing-tab" data-bs-toggle="tab" href="#ongoing" role="tab"
                    aria-controls="ongoing" aria-selected="true">Service Ongoing</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="done-tab" data-bs-toggle="tab" href="#done" role="tab" aria-controls="done"
                    aria-selected="false">Service Done</a>
            </li>
        </ul>


        <?php echo "<h4 class='mt-4'>Riwayat Servis untuk $noRangka</h4>"?>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
                <?php
                        if (empty($arr1)) {
                        ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i> Belum ada servis untuk saat ini
                </div>
                <?php
                        } else {
                        ?>
                <table class="table is-bordered" id="tabel-data1">
                    <thead>
                        <tr>
                            <th>Tanggal Servis</th>
                            <th>Kilometer</th>
                            <th>Detail Servis</th>
                            <th>Status Servis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $noHp = '+6285244449300';
                            foreach ($arr1 as $user_data) {
                            
                                $highlight_css = "";
                                $button_css = "btn btn-info";
                            
                                echo "<tr class = '$highlight_css'>";
                                echo "<td>" . $user_data['tanggalServis'] . "</td>";
                                echo "<td>" . $user_data['kilometer'] . "</td>"; 
                                echo "<td>" . $user_data['idRiwayatBooking'] . "</td>"; 
                                echo "<td><a data-bs-toggle='modal' data-bs-target='#myModal". $user_data['idRiawayatBooking'] ."' class='btn btn-primary' role='button'>LIHAT</a>";
                                echo "<td>Belum Selesai Servis</td>";
                            ?>
                        <div class="modal fade" id="myModal<?php echo $user_data['idRiwayatBooking'];?>" tabindex="-1"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Detail Servis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning" role="alert">
                                            Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php"
                                                target="_blank"><i class='fa fa-question-circle'></i></a>
                                        </div>
                                        <hr>
                                        <small class="text-muted">Tipe Pesanan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama"
                                            value="<?php 
                                                    if($user_data['status'] == 1){
                                                        echo "Melalui Booking";
                                                    }else{
                                                        echo "Tanpa Booking";
                                                    };?>" disabled>
                                        <small class="text-muted">Nama Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama"
                                            value="<?php echo $user_data['namaBooking']; ?>" disabled>
                                        <small class="text-muted">Nomor Telepon Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="telepon"
                                            name="telepon" value="<?php echo $user_data['noTeleponBooking']; ?>"
                                            disabled>
                                        <small class="text-muted">Tanggal Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="alamat"
                                            name="alamat" value="<?php echo $user_data['tanggalServis']; ?>" disabled>
                                        <small class="text-muted">Jam Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noPolisi"
                                            name="noPolisi" value="<?php echo $user_data['jamBooking']; ?>" disabled>
                                        <small class="text-muted">Kilometer:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noRangka"
                                            name="noRangka" value="<?php echo $user_data['kilometer']; ?>" disabled>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }   
                            
                        }
                            ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade show" id="done" role="tabpanel" aria-labelledby="done-tab">
                <?php
                        if (empty($arr2)) {
                        ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i>Belum ada servis yang selesai
                </div>
                <?php
                        } else {
                        ?>
                <table class="table is-bordered" id="tabel-data2">
                    <thead>
                        <tr>
                            <th>Tanggal Servis</th>
                            <th>Kilometer</th>
                            <th>Detail Servis</th>
                            <th>Status Servis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $noHp = '+6285244449300';
                                foreach ($arr2 as $user_data) {
                            
                                    $highlight_css = "";
                                    $button_css = "btn btn-info";
                                
                                        
                                    echo "<tr class = '$highlight_css'>";
                                    echo "<td>" . $user_data['tanggalServis'] . "</td>";
                                    echo "<td>" . $user_data['kilometer'] . "</td>";
                                    
                                    
                                    echo "<td><a data-bs-toggle='modal' class='btn btn-primary' role='button' data-bs-target='#myModal2" . $user_data['idRiwayatBooking'] . "'>LIHAT</a></td>";
                                    echo "<td>Sudah Selesai Servis</td>";
                                ?>
                        <div class="modal fade" id="myModal2<?php echo $user_data['idRiwayatBooking']; ?>" tabindex="-1"
                            aria-labelledby="myModalLabel2" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Detail Servis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning" role="alert">
                                            Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php"
                                                target="_blank"><i class='fa fa-question-circle'></i></a>
                                        </div>
                                        <hr>
                                        <small class="text-muted">Tipe Pesanan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama"
                                            value="<?php 
                                                        if($user_data['status'] == 1){
                                                            echo "Melalui Booking";
                                                        }else{
                                                            echo "Tanpa Booking";
                                                        };?>" disabled>

                                        <small class="text-muted">ID:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama"
                                            value="<?php echo $user_data['idRiwayatBooking']; ?>" disabled>
                                        <small class="text-muted">Nomor Telepon Pemesan:</small>
                                        <small class="text-muted">Nama Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama"
                                            value="<?php echo $user_data['namaBooking']; ?>" disabled>
                                        <small class="text-muted">Nomor Telepon Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="telepon"
                                            name="telepon" value="<?php echo $user_data['noTeleponBooking']; ?>"
                                            disabled>
                                        <small class="text-muted">Tanggal Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="alamat"
                                            name="alamat" value="<?php echo $user_data['tanggalServis']; ?>" disabled>
                                        <small class="text-muted">Jam Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noPolisi"
                                            name="noPolisi" value="<?php echo $user_data['jamBooking']; ?>" disabled>
                                        <small class="text-muted">Kilometer:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noRangka"
                                            name="noRangka" value="<?php echo $user_data['kilometer']; ?>" disabled>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                                }   
                            }
                                ?>
                    </tbody>
                </table>
            </div>



        </div>


        <div id="wrap">
            <div id="main" class="container clear-top">
                <p style="text-align: center;"><i>Reminder Servis Application (RSA) - Version 1.0.0 Beta</i></p>
            </div>
        </div>
        <footer class="footer"></footer>
</body>


</html>