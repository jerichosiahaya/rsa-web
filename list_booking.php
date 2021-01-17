<?php
include_once("include/config.php");
$incoming = mysqli_query(
    $conn,
    "select pelanggan.nama, pelanggan.id, pelanggan.telepon, pelanggan.alamat, mobil.noMesin, mobil.id, mobil.noPolisi, riwayat.noRangka, riwayat.tanggalServis, riwayat.namaBooking, riwayat.noTeleponBooking, riwayat.jamBooking from pelanggan, mobil, riwayat where mobil.noRangka = riwayat.noRangka and mobil.id = pelanggan.id and riwayat.status = 2 and riwayat.done = 0 ORDER BY tanggalServis ASC"
);
$overdue = mysqli_query(
    $conn,
    "select noRangka, tanggalServis, namaBooking,  noTeleponBooking, jamBooking, done, TIMESTAMPDIFF(DAY,curdate(),tanggalServis) AS due from riwayat where status = 2 and TIMESTAMPDIFF(DAY,curdate(),tanggalServis) < 0 ORDER BY tanggalServis ASC"
);
$done = mysqli_query(
    $conn,
    "select pelanggan.nama, pelanggan.id, pelanggan.telepon, pelanggan.alamat, mobil.noMesin, mobil.id, mobil.noPolisi, riwayat.noRangka, riwayat.tanggalServis, riwayat.namaBooking, riwayat.noTeleponBooking, riwayat.jamBooking from pelanggan, mobil, riwayat where mobil.noRangka = riwayat.noRangka and mobil.id = pelanggan.id and riwayat.status = 2 and riwayat.done = 1 ORDER BY tanggalServis ASC"
);
date_default_timezone_set('Asia/Jayapura');
$date = date("Y-m-d");
$arr1 = mysqli_fetch_all($incoming, MYSQLI_ASSOC);
$arr2 = mysqli_fetch_all($overdue, MYSQLI_ASSOC);
$arr3 = mysqli_fetch_all($done, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar Booking | Reminder Servis Berkala</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'include/header.php'; ?>
</head>


<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container mt-4">

        <!-- breadcumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Booking</li>
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
                <a class="nav-link" id="done-tab" data-bs-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Done</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="search-tab" data-bs-toggle="tab" href="#search" role="tab" aria-controls="done" aria-selected="false">Search</a>
            </li>
        </ul>
        <!-- tab header -->

        <div class="tab-content" id="myTabContent">

            <!-- incoming content -->
            <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                <br>
                <table class="table is-bordered tableData" id="tabel-data">
                    <thead>
                        <tr>
                            <th>Nama Pemesan</th>
                            <th>Telepon Pemesan</th>
                            <th>No Polisi</th>
                            <th>Tanggal Servis</th>
                            <th>Jam Booking</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arr1 as $user_data) {
                            echo "<tr>";
                            echo "<td>" . $user_data['namaBooking'] . "</td>";
                            echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                            echo "<td>" . $user_data['tanggalServis'] . "</td>";
                            echo "<td>" . $user_data['jamBooking'] . "</td>";
                            echo "<td><i class='fa fa-info-circle' data-bs-toggle='modal' data-bs-target='#myModal" . $user_data['noRangka'] . "'></i> | <a href='update_booking.php?noRangka=$user_data[noRangka]'><i class='fa fa-edit'></i></a></td>";
                        ?>
                            <!-- modal detail -->
                            <div class="modal fade" id="myModal<?php echo $user_data['noRangka'] ?>" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Detail Kendaraan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning" role="alert">
                                                Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php" target="_blank"><i class='fa fa-question-circle'></i></a>
                                            </div>
                                            <hr>
                                            <small class="text-muted">Nama Pemilik:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="nama" name="nama" value="<?php echo $user_data['nama']; ?>" disabled>
                                            <small class="text-muted">Telepon Pemilik:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="telepon" name="telepon" value="<?php echo $user_data['telepon']; ?>" disabled>
                                            <small class="text-muted">Alamat Pemilik:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="alamat" name="alamat" value="<?php echo $user_data['alamat']; ?>" disabled>
                                            <small class="text-muted">No Polisi:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="noPolisi" name="noPolisi" value="<?php echo $user_data['noPolisi']; ?>" disabled>
                                            <small class="text-muted">No Rangka (VIN):</small>
                                            <input class="form-control form-insert mb-2" type="text" id="noRangka" name="noRangka" value="<?php echo $user_data['noRangka']; ?>" disabled>
                                            <small class="text-muted">No Mesin:</small>
                                            <input class="form-control form-insert mb-2" type="text" id="noMesin" name="noMesin" value="<?php echo $user_data['noMesin']; ?>" disabled>
                                            <?php echo "<a href='riwayat_servis.php?id=$user_data[id]&noRangka=$user_data[noRangka]' target='_blank' rel='noopener noreferrer'><button type='button' class='btn btn-outline-dark btn-sm mt-3'>Lihat riwayat servis >></button></a>"; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal detail -->
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- incoming content -->

            <!-- overdue content -->
            <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                <br>
                <?php
                if (empty($arr2)) {
                ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle"></i> Tidak ada booking overdue
                    </div>
                <?php
                } else {
                ?>
                    <table class="table is-bordered tableData" id="tabel-data2">
                        <thead>
                            <tr>
                                <th>Nama Pemesan</th>
                                <th>No Telepon</th>
                                <th>Tanggal Servis</th>
                                <th>Jam Booking</th>
                                <th>Nomor Rangka</th>
                                <th>Status</th>
                            </tr>
                        <tbody>
                            <?php
                            foreach ($arr2 as $user_data) {
                                echo "<tr>";
                                echo "<td>" . $user_data['namaBooking'] . "</td>";
                                echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                                echo "<td>" . $user_data['tanggalServis'] . "</td>";
                                echo "<td>" . $user_data['jamBooking'] . "</td>";
                                echo "<td>" . $user_data['noRangka'] . "</td>";
                                echo "<td>" . $user_data['done'] . "</td>";
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
            <!-- end overdue content -->

            <!-- done content -->
            <div class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
                <br>
                <table class="table is-bordered tableData" id="tabel-data">
                    <thead>
                        <tr>
                            <th>Nama Pemesan</th>
                            <th>Telepon Pemesan</th>
                            <th>No Polisi</th>
                            <th>Tanggal Servis</th>
                            <th>Jam Booking</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arr3 as $user_data) {
                            echo "<tr>";
                            echo "<td>" . $user_data['namaBooking'] . "</td>";
                            echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                            echo "<td>" . $user_data['tanggalServis'] . "</td>";
                            echo "<td>" . $user_data['jamBooking'] . "</td>";
                            echo "<td><i class='fa fa-info-circle' data-bs-toggle='modal' data-bs-target='#myModal3" . $user_data['noRangka'] . "'></i></td>";
                        ?>
                            <!-- modal -->
                            <div class="modal fade" id="myModal3<?php echo $user_data['noRangka'] ?>" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Detail Kendaraan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning" role="alert">
                                                Data pemilik dan pemesan (<i>booking</i>) bisa berbeda <a href="index.php" target="_blank"><i class='fa fa-question-circle'></i></a>
                                            </div>
                                            <hr>
                                            <small class="text-muted">Nama Pemilik:</small>
                                            <input class="form-control form-insert" type="text" id="nama" name="nama" value="<?php echo $user_data['nama']; ?>" disabled>
                                            <small class="text-muted">Telepon Pemilik:</small>
                                            <input class="form-control form-insert" type="text" id="telepon" name="telepon" value="<?php echo $user_data['telepon']; ?>" disabled>
                                            <small class="text-muted">Alamat Pemilik:</small>
                                            <input class="form-control form-insert" type="text" id="alamat" name="alamat" value="<?php echo $user_data['alamat']; ?>" disabled>
                                            <small class="text-muted">No Polisi:</small>
                                            <input class="form-control form-insert" type="text" id="noPolisi" name="noPolisi" value="<?php echo $user_data['noPolisi']; ?>" disabled>
                                            <small class="text-muted">No Rangka (VIN):</small>
                                            <input class="form-control form-insert" type="text" id="noRangka" name="noRangka" value="<?php echo $user_data['noRangka']; ?>" disabled>
                                            <small class="text-muted">No Mesin:</small>
                                            <input class="form-control form-insert" type="text" id="noMesin" name="noMesin" value="<?php echo $user_data['noMesin']; ?>" disabled>
                                            <?php echo "<a href='riwayat_servis.php?id=$user_data[id]&noRangka=$user_data[noRangka]' target='_blank' rel='noopener noreferrer'><button type='button' class='btn btn-outline-dark btn-sm'>Lihat riwayat servis >></button></a>"; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- end done content -->

            <!-- search content -->
            <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">

                <div class="col-sm-2">
                    <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>#search" class="pt-3">
                        <input class='form-control' type='number' id='days' name='days' placeholder="Sisa hari (due)" required>
                </div>
                <button type='submit' name='submit' class='btn btn-primary mt-2' role='button'>Search</a></button>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    //echo ("Days: " . $_POST['days'] . "<br>");
                    $due = $_POST['days'];
                    $search = mysqli_query(
                        $conn,
                        "select pelanggan.nama, pelanggan.id, pelanggan.telepon, pelanggan.alamat, mobil.noMesin, mobil.id, mobil.noPolisi, riwayat.noRangka, riwayat.tanggalServis, riwayat.namaBooking, riwayat.noTeleponBooking, riwayat.jamBooking from pelanggan, mobil, riwayat where mobil.noRangka = riwayat.noRangka and mobil.id = pelanggan.id and riwayat.status = 2 and riwayat.done = 0 and TIMESTAMPDIFF(DAY,curdate(),tanggalServis) = $due ORDER BY tanggalServis ASC"
                    );
                    $arr4 = mysqli_fetch_all($search, MYSQLI_ASSOC);
                ?>
                    <div class="container mt-4">
                        <?php
                        if (empty($arr4)) {
                        ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fa fa-info-circle"></i> Tidak ada data
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="printThis">
                                <table class="table is-bordered" id="tabel-data3">
                                    <thead>
                                        <tr>
                                            <th>Nama Pemesan</th>
                                            <th>Telepon Pemesan</th>
                                            <th>No Polisi</th>
                                            <th>Tanggal Servis</th>
                                            <th>Jam Booking</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($arr4 as $user_data) {
                                            $tglServis = date_create($user_data['tanggalServis']);
                                            echo "<tr>";
                                            echo "<td>" . $user_data['namaBooking'] . "</td>";
                                            echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                                            echo "<td>" . $user_data['noPolisi'] . "</td>";
                                            echo "<td>" . date_format($tglServis, 'd-m-Y') . "</td>";
                                            echo "<td>" . $user_data['jamBooking'] . "</td>";
                                        ?>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-3" id="print"><i class="fa fa-print"></i> Print</button>
                            <button type="button" class="btn btn-warning btn-sm mt-3" id="excel"><i class="fa fa-file-excel"></i> Export to Excel</button>
                    <?php
                        }
                    }
                    ?>
                    </div>
            </div>
            <!-- search content -->
        </div>


    </div>
    </div>

    <script>
        $(document).ready(function() {
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
            // Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            })
            $('[data-toggle="tooltip"]').tooltip();
            $('.tableData').DataTable({
                "ordering": false
            });
            $('#print').on('click', function() {
                $('.printThis').printThis({
                    footer: null,
                    removeScripts: true
                });
            });
            $('#excel').on('click', function() {
                $(".printThis").table2excel({
                    //exclude: ".excludeThisClass",
                    name: "Worksheet Name",
                    filename: "daftarbooking.xls", // do include extension
                    preserveColors: false // set to true if you want background colors and font colors preserved
                });
            });
        });
    </script>

</body>
