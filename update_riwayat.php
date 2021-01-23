<?php
include_once("include/config.php");
global $id, $noRangka;
$date = date("Y-m-d");
$id = $_GET['id'];
$noRangka = $_GET['noRangka'];
$result = mysqli_query($conn, "select riwayat.noRangka, tanggalServis, namaBooking, noTeleponBooking, jamBooking, done, detail_servis.kilometer
from riwayat, detail_servis
where detail_servis.noRangka = '$noRangka' and riwayat.noRangka = '$noRangka' and .riwayat.status = 2 and riwayat.done = 0");
$arr = mysqli_fetch_array($result, MYSQLI_ASSOC);
date_default_timezone_set('Asia/Jayapura');
$today = new DateTime('now');
$next = (clone $today)->modify('+6 month');
$time = date("H:i");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Insert Data</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'include/header.php'; ?>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <!-- Check Data -->
    <!-- <pre>
    <?php
    print_r($arr);
    ?>
    </pre> -->
    <div class="container mt-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Arsip</li>
            </ol>
        </nav>
        <form action="" id="fupForm" name="form1" method="post">
            <!-- yang di-dihidden -->
            <input class="form-control form-insert" type="text" id="status" name="status" value="2" hidden>
            <input class="form-control form-insert" type="text" id="done" name="done" value="1" hidden>
            <input class="form-control form-insert" type="text" id="kilometerPrevious" name="kilometerPrevious" value="<?php echo $arr['kilometer']; ?>" hidden>
            <!-- yang di-disabled -->
            <small class="text-muted">Nama Pemesan:</small>
            <input class="form-control form-insert mb-3" type="text" id="nama" name="nama" value="<?php echo $arr['namaBooking']; ?>" disabled>
            <small class="text-muted">No Rangka:</small>
            <input class="form-control form-insert mb-3" type="text" id="noRangka" name="noRangka" value="<?php echo $arr['noRangka']; ?>" disabled>
            <input class="form-control form-insert" type="text" id="telepon" name="telepon" value="<?php echo $arr['noTeleponBooking']; ?>" hidden>
            <small class="text-muted">Diservis Tanggal:</small>
            <input class="form-control form-insert mb-3" type="text" id="tanggalServis" name="tanggalServis" value="<?php echo $arr['tanggalServis']; ?>" disabled>
            <small class="text-muted">Servis Selanjutnya:</small>
            <input class="form-control form-insert mb-3" type="text" id="tanggalServisSelanjutnya" name="tanggalServisSelanjutnya" value="<?php echo $next->format('Y-m-d'); ?>" disabled>
            <input class="form-control form-insert" type="text" id="jamBooking" name="jamBooking" value="<?php echo $time; ?>" hidden>
            <!-- yang di-input -->
            <div class="alert alert-warning mt-4" role="alert">
                Silahkan isi kilometer terakhir yang ada pada kendaraan, setelah itu tekan submit. Bagian ini menyatakan bahwa kendaraan telah selesai
                diservis dan informasi ini akan disimpan sebagai arsip bengkel.
            </div>
            <input class="form-control form-insert" type="text" id="kilometer" name="kilometer" placeholder="KM">
            <!-- button -->
            <!-- <input type="button" name="hapus" class="btn btn-info" value="Hapus" id="hapus"> -->
            <input type="button" name="submit" class="btn btn-primary" value="Submit" id="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <!--<input type="button" class="btn btn-primary" value="Simpan" data-bs-toggle="modal" data-bs-target="#exampleModal2">-->
    </div>
    <!-- Modal sebelum submit -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Apakah data sudah benar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" name="simpan" id="simpan">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal sebelum submit -->
    </form>
    </div>
    <script>
        $(document).ready(function() {
            var tanggalServis = $('#tanggalServis').val();
            var next = moment(tanggalServis);
            var tanggalServisSelanjutnya = next.add(6, 'months').format('YYYY-MM-DD');
            $("#kilometer").focus();
            $("#kilometer").autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                aForm: true,
                aSign: ' KM',
                pSign: 's',
                vMax: '99999999999',
                vMin: '-999999999'
            });
            $('#kilometer').on('change', function() {
                a = $('#kilometer').val();
                b = a.replace(/,| KM/g, "");
                var kmPrev = $('#kilometerPrevious').val();
                if (a <= kmPrev) {
                    alert('Input kilometer tidak valid')
                    $('#kilometer').val("");

                }
            });
            // $('#submit').on('click', function() {
            //     var a = $('#kilometer').val();
            //     var kmPrev = $('#kilometerPrevious').val();
            //     if (a < kmPrev) {
            //         alert('Input kilometer tidak valid')
            //         $('#kilometer').val("");
            //     }
            // });
            $('#simpan').on('click', function() {
                var status = $('#status').val();
                var done = $('#done').val();
                //var nama = $('#nama').val();
                //var telepon = $('#telepon').val();
                //var jamBooking = $('#jamBooking').val();
                var noRangka = $('#noRangka').val();
                var kilometer = $('#kilometer').val().replace(/,| KM/g, "");
                var tanggalServis = $('#tanggalServis').val();
                //var tanggalServisSelanjutnya = $('#tanggalServisSelanjutnya').val();
                if (kilometer != "") {
                    $.ajax({
                        type: "POST",
                        url: "update_riwayat_proses.php",
                        data: {
                            'noRangka': noRangka,
                            'kilometer': kilometer,
                            'status': status,
                            'done': done,
                            'tanggalServis': tanggalServis,
                            'tanggalServisSelanjutnya': tanggalServisSelanjutnya,
                        },
                        cache: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                alert("Success!");
                                window.location = 'index.php';
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