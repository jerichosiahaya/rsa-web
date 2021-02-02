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
    <style>
        .hidden-print {
            display: none;
        }

        @media print {
            .hidden-print {
                display: block;
            }
        }

        .hoverThis:hover {
            background-color: whitesmoke;
        }

        .hoverThis[aria-expanded=true] .fa-angle-down {
            display: none;
        }

        .hoverThis[aria-expanded=false] .fa-angle-up {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <!-- Check Data -->
    <!-- <pre>
    <?php
    // print_r($id);
    // print_r($data);
    ?>
    </pre> -->

    <div class="container mt-4 mb-5">

        <!-- breadcumb -->
        <div class="row justify-content-between">
            <div class="col-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                    </ol>
                </nav>
            </div>
            <div class="col-2" style="text-align: right;">
                <a href="insert.php" class='btn btn-success btn-sm customButton' role='button'>+Input baru</a>
            </div>
        </div>
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
                            <!-- <th>Tanggal Servis Terakhir</th> -->
                            <th>Servis Selanjutnya</th>
                            <th>Due</th>
                            <th>Scheduled</th>
                            <th>Servis Done</th>
                            <th>Booking Servis</th>
                            <th></th>
                            <!-- <th>Detail Pelanggan</th>
                        <th>Whatsapp</th>
                            -->
                        </tr>
                    <tbody>
                        <?php
                        foreach ($data as $user_data) {
                            if ($user_data['due'] >= 0) {
                                // update tanggal servis selanjutnya
                                $today = new DateTime('now');
                                $next = (clone $today)->modify('+6 month');
                                // atur warna row
                                $highlight_css = "";
                                $button_css = "btn btn-info";
                                if ($user_data['due'] <= 3 && $user_data['due'] > 0) {
                                    $highlight_css = "table-danger";
                                    $button_css = "btn btn-danger";
                                } elseif ($user_data['due'] == 0) {
                                    $highlight_css = "table-warning";
                                    //$button_css = "btn btn-info disabled";
                                }
                                // munculin data dalam row
                                echo "<tr class = '$highlight_css'>";
                                echo "<td>" . $user_data['nama'] . "</td>";
                                echo "<td>" . $user_data['telepon'] . "</td>";
                                echo "<td>" . $user_data['noPolisi'] . "</td>";
                                // echo "<td class='text-center'>" . $user_data['tglServisTerakhir'] . "</td>";
                                echo "<td class='text-center'>" . date('d-m-Y', strtotime($user_data['tglServisSelanjutnya'])) . "</td>";
                                echo "<td>" . $user_data['due'] . "</td>";
                                // format tanggal
                                if ($user_data['Booking'] != "-") {
                                    $dateBooking = $user_data['Booking'];
                                    //echo date('d-m-Y', strtotime($dateBooking));
                                    echo "<td> <b>" . date('d-m-Y', strtotime($dateBooking)) . "</b> </td>";
                                } else {
                                    echo "<td> <b>" . $user_data['Booking'] . "</b> </td>";
                                }
                                // format button depends on booking
                                if ($user_data['Booking'] == "-") {
                                    echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                } else {
                                    echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-secondary' role='button'>Update</a></td>";
                                }
                        ?>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="detail.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Detail</a></li>
                                            <li><a class="dropdown-item" href="edit.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Edit</a></li>
                                            <li><a class="dropdown-item" href="https://wa.me/<?php echo trim($user_data['telepon'], " "); ?>?text=Halo Sdr/i <?php echo $user_data['nama']; ?>, kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi <?php echo $user_data['noPolisi']; ?> sudah harus diservis." target="_blank">Whatsapp</a></li>
                                        </ul>
                                    </div>
                                </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- incoming content end -->

            <!-- Overdue Content -->
            <div class=" tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                <br>
                <table class="table is-bordered" id="tabel-data2">
                    <thead>
                        <tr>
                            <th>Nama Pemilik</th>
                            <th>Telepon</th>
                            <th>No Polisi</th>
                            <!-- <th>Tanggal Servis Terakhir</th> -->
                            <th>Servis Selanjutnya</th>
                            <th>Due</th>
                            <th>Scheduled</th>
                            <th>Servis Done</th>
                            <th>Booking Servis</th>
                            <th></th>
                            <!-- <th>Detail Pelanggan</th>
                    <th>Whatsapp</th>
                        -->
                        </tr>
                    <tbody>
                        <?php
                        foreach ($data as $user_data) {
                            if ($user_data['due'] < 0) {
                                // update tanggal servis selanjutnya
                                $today = new DateTime('now');
                                $next = (clone $today)->modify('+6 month');
                                // atur warna row
                                $highlight_css = "";
                                $button_css = "btn btn-info";
                                if ($user_data['due'] < 0) {
                                    $highlight_css = "table-secondary";
                                    //$button_css = "btn btn-danger";
                                } else {
                                    $highlight_css = "table-warning";
                                    //$button_css = "btn btn-info disabled";
                                }
                                // munculin data dalam row
                                echo "<tr class = '$highlight_css'>";
                                echo "<td>" . $user_data['nama'] . "</td>";
                                echo "<td>" . $user_data['telepon'] . "</td>";
                                echo "<td>" . $user_data['noPolisi'] . "</td>";
                                // echo "<td class='text-center'>" . $user_data['tglServisTerakhir'] . "</td>";
                                echo "<td class='text-center'>" . date('d-m-Y', strtotime($user_data['tglServisSelanjutnya'])) . "</td>";
                                echo "<td>" . $user_data['due'] . "</td>";
                                // format tanggal
                                if ($user_data['Booking'] != "-") {
                                    $dateBooking = $user_data['Booking'];
                                    //echo date('d-m-Y', strtotime($dateBooking));
                                    echo "<td> <b>" . date('d-m-Y', strtotime($dateBooking)) . "</b> </td>";
                                } else {
                                    echo "<td> <b>" . $user_data['Booking'] . "</b> </td>";
                                }
                                if ($user_data['Booking'] == "-") {
                                    echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                } else {
                                    echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-secondary' role='button'>Update</a></td>";
                                }
                        ?>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="detail.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Detail</a></li>
                                            <li><a class="dropdown-item" href="edit.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Edit</a></li>
                                            <li><a class="dropdown-item" href="https://wa.me/<?php echo trim($user_data['telepon'], " "); ?>?text=Halo Sdr/i <?php echo $user_data['nama']; ?>, kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi <?php echo $user_data['noPolisi']; ?> sudah harus diservis." target="_blank">Whatsapp</a></li>
                                        </ul>
                                    </div>
                                </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!--<a href="add.php"><button class='button is-success is-rounded' style="margin-left: 32em" name='submit'><b>+</b></button></a>-->
            </div>
            <!-- End Overdue Content -->


            <!-- Search Content -->
            <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">
                <div class="hoverThis" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <center><i class="fas fa-angle-up mt-3"></i></center>
                    <center><i class="fas fa-angle-down mt-3"></i></center>
                </div>
                <div class="collapse in show" id="collapseExample">
                    <div class="alert alert-info mt-4" role="alert">
                        Cari berdasarkan <b>due</b> atau <b>sisa hari</b>. Misalkan besok = 1, kemarin = -1, seminggu ke depan = 7.
                    </div>

                    <div class='container'>
                        <div class="row">
                            <div class="col-sm-3">
                                <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>#search" class="pt-2">
                                    <div class="input-group">
                                        <input class='form-control' type='number' name='days' placeholder="Sisa hari (due)" required>
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                    <button type='submit' name='submit' id="submitSearch" class='btn btn-primary mt-3' role='button'>Search</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_POST['submit'])) {
                    //echo("Days: " . $_POST['days'] . "<br>");
                    $id = $_POST['days'];
                ?>
                    <br>
                    <table class="table is-bordered" id="tabel-data3">
                        <thead>
                            <tr>
                                <th>Nama Pemilik</th>
                                <th>Telepon</th>
                                <th>No Polisi</th>
                                <!-- <th>Tanggal Servis Terakhir</th> -->
                                <th>Tanggal Servis Selanjutnya</th>
                                <th>Due</th>
                                <th>Scheduled</th>
                                <th>Servis Done</th>
                                <th>Booking Servis</th>
                                <th></th>
                                <!-- <th>Detail Pelanggan</th>
                            <th>Whatsapp</th>
                                -->
                            </tr>
                        <tbody>
                            <?php
                            foreach ($data as $user_data) {
                                if ($user_data['due'] == $id) {
                                    // update tanggal servis selanjutnya
                                    $today = new DateTime('now');
                                    $next = (clone $today)->modify('+6 month');
                                    // munculin data dalam row
                                    echo "<tr>";
                                    echo "<td>" . $user_data['nama'] . "</td>";
                                    echo "<td>" . $user_data['telepon'] . "</td>";
                                    echo "<td>" . $user_data['noPolisi'] . "</td>";
                                    // echo "<td class='text-center'>" . $user_data['tglServisTerakhir'] . "</td>";
                                    echo "<td class='text-center'>" . $user_data['tglServisSelanjutnya'] . "</td>";
                                    echo "<td>" . $user_data['due'] . "</td>";
                                    echo "<td>" . $user_data['Booking'] . "</td>";
                                    if ($user_data['Booking'] == "-") {
                                        echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                        echo "
                                                    <td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                    } else {
                                        echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                        echo "
                                                    <td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                    }
                            ?>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Function</button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detail.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Detail</a></li>
                                                <li><a class="dropdown-item" href="edit.php?id=<?php echo $user_data['id'] . "&noRangka=" . $user_data['noRangka']; ?>">Edit</a></li>
                                                <li><a class="dropdown-item" href="https://wa.me/<?php echo trim($user_data['telepon'], " "); ?>?text=Halo Sdr/i <?php echo $user_data['nama']; ?>, kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi <?php echo $user_data['noPolisi']; ?> sudah harus diservis." target="_blank">Whatsapp</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="hidden-print">
                        <table class="table is-bordered" id="tabel-data3">
                            <thead>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <th>Telepon</th>
                                    <th>No Polisi</th>
                                    <!-- <th>Tanggal Servis Terakhir</th> -->
                                    <th>Tanggal Servis Selanjutnya</th>
                                    <th>Due</th>
                                    <th>Scheduled</th>
                                    <!-- <th>Servis Done</th> -->
                                    <!-- <th>Booking Servis</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($data as $user_data) {
                                    if ($user_data['due'] == $id) {
                                        echo "<tr class='$highlight_css'>";
                                        echo "<td>" . $user_data['nama'] . "</td>";
                                        echo "<td>" . $user_data['telepon'] . "</td>";
                                        echo "<td>" . $user_data['noPolisi'] . "</td>";
                                        // echo "<td class='text-center'>" . $user_data['tglServisTerakhir'] . "</td>";
                                        echo "<td class='text-center'>" . $user_data['tglServisSelanjutnya'] . "</td>";
                                        echo "<td>" . $user_data['due'] . "</td>";
                                        echo "<td>" . $user_data['Booking'] . "</td>";
                                ?>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-3" id="print"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-warning btn-sm mt-3" id="excel"><i class="fa fa-file-excel"></i> Export to Excel</button>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- End Search Content -->
        <!-- <i class="fas fa-angle-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div> -->
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable({
                "ordering": true,
                "order": [
                    [4, 'asc']
                ],
                "columnDefs": [{
                    "targets": [8, 7, 6],
                    "orderable": false
                }]
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
            $('#print').on('click', function() {
                //$('#printThis').removeAttr('hidden');
                $('.hidden-print').printThis({
                    footer: null,
                    importCSS: true, // import parent page css
                    importStyle: false
                });
            });
            $("#tutupToggle").click(function() {
                $("#toggleThis").hide();
            });
            $('#excel').on('click', function() {
                $(".hidden-print").table2excel({
                    //exclude: ".excludeThisClass",
                    name: "Worksheet Name",
                    filename: "daftarservis.xls", // do include extension
                    preserveColors: false // set to true if you want background colors and font colors preserved
                });
            });
        });
    </script>
</body>
<!-- <?php include 'include/footer.php' ?> -->

</html>