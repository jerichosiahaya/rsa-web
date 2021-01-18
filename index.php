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
    // print_r($arr);
    // print_r($data);
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
                        foreach ($data as $user_data) {
                            if($user_data['due'] >= 0){
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
                                echo "<td>" . $user_data['Booking'] . "</td>";
                                if($user_data['Booking'] == "-"){
                                    echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                }else{
                                    echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    echo "<td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                }
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
                        }
                        ?>
                    </tbody>
                </table>
            <a href="insert.php" class='btn btn-success btn-sm' role='button'>+</a>
        </div>
        <!-- incoming content end -->

        <!-- Overdue Content -->
        <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
            <br>
            <table class="table is-bordered" id="tabel-data2">
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
                    foreach ($data as $user_data) {
                        if($user_data['due'] < 0){
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
                            echo "<td>" . $user_data['Booking'] . "</td>";
                            if($user_data['Booking'] == "-"){
                                echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                            }else{
                                echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                echo "<td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                            }
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
                    }
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
                        <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>#search" class="pt-5">
                            <div class='form-group row'>
                                <label class='col-sm-3' for='days'>Days: </label>
                                <div class='col-sm-6'><input class='form-control' type='number' name='days' placeholder="Sisa Hari..." required></div>
                            </div>
                            <button type='submit' name='submit' class='btn btn-primary' role='button'>Search</a>
                        </form>
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
                            foreach ($data as $user_data) {
                                if($user_data['due'] == $id){
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
                                    echo "<td>" . $user_data['Booking'] . "</td>";
                                    if($user_data['Booking'] == "-"){
                                        echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                        echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                    }else{
                                        echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                        echo "<td><a href='update_booking.php?noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></td>";
                                    }
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
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            })
        });
    </script>
</body>

</html>