<?php
include_once("include/config.php");
global $id, $noRangka;
$noRangka = $_GET['noRangka'];
$id = $_GET['id'];

$result_riwayat_ongoing = mysqli_query(
    $conn,
    "select * from riwayat where riwayat.noRangka = '$noRangka' AND done = 0 order by tanggalServis ASC"
);

$result_riwayat_done = mysqli_query(
    $conn,
    "select * from riwayat where riwayat.noRangka = '$noRangka' AND done = 1 order by tanggalServis ASC"
);

$arr1 = mysqli_fetch_all($result_riwayat_ongoing, MYSQLI_ASSOC);
$arr2 = mysqli_fetch_all($result_riwayat_done, MYSQLI_ASSOC);
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Riwayat Servis: <?php echo $noRangka; ?> | RSA</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'include/header.php'; ?>
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><?php echo "<a href='detail.php?id=$id&noRangka=$noRangka'" ?>>Detail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Servis</li>
            </ol>
        </nav>

        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Riwayat servis untuk kendaraan dengan VIN: <strong><?php echo $noRangka ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="ongoing-tab" data-bs-toggle="tab" href="#ongoing" role="tab" aria-controls="ongoing" aria-selected="true">Service Ongoing</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="done-tab" data-bs-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Service Done</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <!-- incoming tab -->
            <div class="tab-pane fade show active" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
                <table class="table is-bordered" id="tabel-data1">
                    <thead>
                        <tr>
                            <th>Tanggal Servis (<i>scheduled</i>)</th>
                            <th>Kilometer</th>
                            <th>Detail Servis</th>
                            <!-- <th>Status Servis</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arr1 as $user_data) {
                            echo "<tr>";
                            echo "<td>" . date('d-m-Y', strtotime($user_data['tanggalServis'])) . "</td>";
                            echo "<td> Belum diinput </td>";
                            //echo "<td><a data-bs-toggle='modal' data-bs-target='#myModal' class='btn btn-primary' role='button'>LIHAT</a>";
                            echo "<td><i class='fa fa-info-circle' data-bs-toggle='modal' data-bs-target='#myModal" . $user_data['idRiwayatBooking'] . "'></i></td>";
                            // echo "<td>" . $user_data['done'] . "</td>";
                            echo "</tr>";
                        ?>
                            <div class="modal fade" id="myModal<?php echo $user_data['idRiwayatBooking'] ?>" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Detail Servis</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning" role="alert">
                                                Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php" target="_blank"><i class='fa fa-question-circle'></i></a>
                                            </div>
                                            <hr>
                                            <small class="text-muted">Tipe Pesanan:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="nama" name="nama" value="<?php
                                                                                                                                    if ($user_data['status'] == 1) {
                                                                                                                                        echo "Melalui Booking (scheduled)";
                                                                                                                                    } else {
                                                                                                                                        echo "Tanpa Booking (walk in)";
                                                                                                                                    }; ?>" disabled>
                                            <small class="text-muted">Nama Pemesan:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="nama" name="nama" value="<?php echo $user_data['namaBooking']; ?>" disabled>
                                            <small class="text-muted">Nomor Telepon Pemesan:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="telepon" name="telepon" value="<?php echo $user_data['noTeleponBooking']; ?>" disabled>
                                            <small class="text-muted">Tanggal Diservis:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="alamat" name="alamat" value="<?php echo $user_data['tanggalServis']; ?>" disabled>
                                            <small class="text-muted">Jam Diservis:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="noPolisi" name="noPolisi" value="<?php echo $user_data['jamBooking']; ?>" disabled>
                                            <small class="text-muted">Kilometer:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="noRangka" name="noRangka" value="<?php echo $user_data['kilometer']; ?>" disabled>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade show" id="done" role="tabpanel" aria-labelledby="done-tab">
                <table class="table is-bordered" id="tabel-data2">
                    <thead>
                        <tr>
                            <th>Tanggal Servis</th>
                            <th>Kilometer</th>
                            <th>Detail Servis</th>
                           <!-- <th>Status Servis</th> -->
                        </tr>
                    <tbody>
                        <?php
                        $noHp = '+6285244449300';
                        foreach ($arr2 as $user_data) {
                            echo "<tr>";
                            echo "<td>" . date('d-m-Y', strtotime($user_data['tanggalServis'])) . "</td>";
                            echo "<td>" . $user_data['kilometer'] . "</td>";
                            echo "<td><i class='fa fa-info-circle' data-bs-toggle='modal' data-bs-target='#myModal2" . $user_data['idRiwayatBooking'] . "'></i></td>";
                            // echo "<td>" . $user_data['done'] . "</td>";
                        ?>
                       <div class="modal fade" id="myModal2<?php echo $user_data['idRiwayatBooking'] ?>" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Detail Servis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning" role="alert">
                                            Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php" target="_blank"><i class='fa fa-question-circle'></i></a>
                                        </div>
                                        <hr>
                                        <small class="text-muted">Tipe Pesanan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama" value="<?php
                                                                                                                                if ($user_data['status'] == 1) {
                                                                                                                                    echo "Melalui Booking (scheduled)";
                                                                                                                                } else {
                                                                                                                                    echo "Tanpa Booking (walk in)";
                                                                                                                                }; ?>" disabled>
                                        <small class="text-muted">Nama Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="nama" name="nama" value="<?php echo $user_data['namaBooking']; ?>" disabled>
                                        <small class="text-muted">Nomor Telepon Pemesan:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="telepon" name="telepon" value="<?php echo $user_data['noTeleponBooking']; ?>" disabled>
                                        <small class="text-muted">Tanggal Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="alamat" name="alamat" value="<?php echo $user_data['tanggalServis']; ?>" disabled>
                                        <small class="text-muted">Jam Diservis:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noPolisi" name="noPolisi" value="<?php echo $user_data['jamBooking']; ?>" disabled>
                                        <small class="text-muted">Kilometer:</small>
                                        <input class="form-control form-insert mb-2" type="text" id="noRangka" name="noRangka" value="<?php echo $user_data['kilometer']; ?>" disabled>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>



        </div>
</body>


</html>