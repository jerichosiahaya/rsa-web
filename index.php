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
                                foreach ($arr3 as $book) {
                                    if ($book['noRangka'] == $user_data['noRangka']) {
                                        echo "<td class='text-center'>" . $book['tanggalServis'] . "</td>";
                                        //echo "<td class='text-center'><input type='button' name='submit' class='btn btn-primary' value='Submit' id='" . $user_data['noRangka'] . "' data-bs-toggle='modal' data-bs-target='#modal2" . $user_data['noRangka'] . "'></td>";
                                        echo "<td><a href='update_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    } else {
                                        echo "<td class='text-center'> - </td>";
                                        //echo "<td class='text-center'><input type='button' name='submit' class='btn btn-primary' value='Submit' id='" . $user_data['noRangka'] . "' data-bs-toggle='modal' data-bs-target='#modal1" . $user_data['noRangka'] . "'></td>";
                                        echo "<td><a href='insert_riwayat.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Submit</a>";
                                    }
                                }
                            }
                            // echo "<td><a href='detail.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>LIHAT</a> | <a href='edit.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>EDIT</a></td>";
                            // echo "<td><a href='https://wa.me/" . $user_data['telepon'] . "?text=Halo Sdr/i " . $user_data['nama'] . ", kami dari CV Kombos Toyota Jayapura ingin mengingatkan bahwa mobil Anda dengan no polisi " . $user_data['noPolisi'] . " sudah harus diservis.' class='$button_css' role='button'>KIRIM</a></td>";
                            echo "<td><a href='booking.php?id=$user_data[id]&noRangka=$user_data[noRangka]' class='btn btn-primary' role='button'>Booking</a></tr>";
                        ?>
                            <!-- modal sebelum submit 1 -->
                            <div class="modal fade" id="modal1<?php echo $user_data['noRangka'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <form id="insert_form" name="insert_form" method="post">
                                            <div class="modal-body">
                                                <small class="text-muted">Nama Pemilik:</small>
                                                <input class="form-control form-insert" type="text" id="nama" name="nama" value="<?php echo $user_data['nama']; ?>" disabled>
                                                <small class="text-muted">Telepon:</small>
                                                <input class="form-control form-insert" type="text" id="telepon" name="telepon" value="<?php echo $user_data['telepon']; ?>" disabled>
                                                <small class="text-muted">Jam:</small>
                                                <input class="form-control form-insert" type="text" id="jamBooking" name="jamBooking" value="<?php echo $time; ?>" disabled>
                                                <input class="form-control form-insert" type="text" id="status" name="status" value="1" hidden>
                                                <small class="text-muted">No Rangka:</small>
                                                <input class="form-control form-insert" type="text" id="noRangka" name="noRangka" value="<?php echo $user_data['noRangka']; ?>" disabled>
                                                <small class="text-muted">Tanggal Servis (today):</small>
                                                <input class="form-control form-insert" type="text" id="tglServis" name="tglServis" value="<?php echo $date ?>" disabled>
                                                <small class="text-muted">Tanggal Servis Selanjutnya:</small>
                                                <input class="form-control form-insert" type="text" id="tglServisSelanjutnya" name="tglServisSelanjutnya" value="<?php echo $next->format('Y-m-d'); ?>" disabled>
                                                <small class="text-muted">Kilometer Terakhir:</small>
                                                <input class="form-control form-insert kilometer" type="text" id="kilometer" name="kilometer" placeholder="KM">
                                                <input type="submit" class="btn btn-success" name="insert" id="insert" id="Submit">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <!-- <button type="button" class="btn btn-primary" name="simpan1" id="simpan1<?php echo $user_data['noRangka'] ?>">Save</button> -->
                                    </div>
                                </div>
                            </div>
            </div>
            <!-- modal sebelum submit 1 -->

            <!-- modal sebelum submit 2 -->
            <div class="modal fade" id="modal2<?php echo $user_data['noRangka'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="update_form" name="update_form" method="post">
                                <small class="text-muted">Nama Booking:</small>
                                <input class="form-control form-insert" type="text" id="nama" name="nama" value="<?php echo $book['namaBooking']; ?>" disabled>
                                <small class="text-muted">Telepon Booking:</small>
                                <input class="form-control form-insert" type="text" id="telepon" name="telepon" value="<?php echo $book['noTeleponBooking']; ?>" disabled>
                                <small class="text-muted">Jam:</small>
                                <input class="form-control form-insert" type="text" id="jamBooking" name="jamBooking" value="<?php echo $book['jamBooking']; ?>" disabled>
                                <input class="form-control form-insert" type="text" id="status" name="status" value="2" hidden>
                                <small class="text-muted">No Rangka:</small>
                                <input class="form-control form-insert" type="text" id="noRangka" name="noRangka" value="<?php echo $book['noRangka']; ?>" disabled>
                                <small class="text-muted">Tanggal Servis (today):</small>
                                <input class="form-control form-insert" type="text" id="tglServis" name="tglServis" value="<?php echo $book['tanggalServis'] ?>" disabled>
                                <small class="text-muted">Tanggal Servis Selanjutnya:</small>
                                <input class="form-control form-insert" type="text" id="tglServisSelanjutnya" name="tglServisSelanjutnya" value="<?php echo $next->format('Y-m-d'); ?>" disabled>
                                <small class="text-muted">Kilometer Terakhir:</small>
                                <input class="form-control form-insert kilometer" type="text" id="kilometer" name="kilometer" placeholder="KM">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" name="simpan1" id="simpan2<?php echo $user_data['noRangka'] ?>">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal sebelum submit 2 -->
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
            // new
            $(".kilometer").autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                aForm: true,
                aSign: ' KM',
                pSign: 's',
                vMax: '99999999999',
                vMin: '-999999999'
            });
            $('.kilometer').on('change', function() {
                a = $('#kilometer').val();
                b = a.replace(/,| KM/g, "");
                //alert(b);
                //alert($('#kilometer').val());
            });
            // simpan ke database
            $('#insert_form').on('submit', function() {
                var nama = $('#nama').val();
                var telepon = $('#telepon').val();
                var jamBooking = $('#jamBooking').val();
                var noRangka = $('#noRangka').val();
                var status = $('#status').val();
                var tglServis = $('#tglServis').val();
                var kilometer = $('#kilometer').val().replace(/,| KM/g, "");
                var tglServisSelanjutnya = $('#tglServisSelanjutnya').val();
                if (nama != "" && telepon != "" && jamBooking != "" && noRangka != "" && tglServis != "" && tglServisSelanjutnya != "" && kilometer != "") {
                    $.ajax({
                        type: "POST",
                        url: "insert_riwayat_proses.php",
                        data: {
                            'nama': nama,
                            'telepon': telepon,
                            'noRangka': noRangka,
                            'jamBooking': jamBooking,
                            'status': status,
                            'kilometer': kilometer,
                            'tglServis': tglServis,
                            'tglServisSelanjutnya': tglServisSelanjutnya,
                        },
                        cache: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                //$("#butsave").removeAttr("disabled");
                                //$('#fupForm').find('input:text').val('');
                                //$("#success").show();
                                //$('#success').html('Data added successfully !');
                                alert("Success!");
                                location.reload();
                            } else if (dataResult.statusCode == 201) {
                                alert("Error occured !");
                            }

                        }
                    });
                } else {
                    alert('Please fill all the field !');
                }
            });
        });
    </script>
</body>

</html>