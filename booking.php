<?php
include_once("include/config.php");
global $id, $noRangka;
$date = date("Y-m-d");
$id = $_GET['id'];
$noRangka = $_GET['noRangka'];
$result = mysqli_query($conn, "select nama, telepon, alamat, noPolisi, deliveryDate, detail_servis.noRangka, tglServisTerakhir, tglServisSelanjutnya from pelanggan, 
mobil, detail_servis where pelanggan.id = $id and mobil.noRangka = '$noRangka' and mobil.noRangka = detail_servis.noRangka ORDER BY tglServisSelanjutnya ASC");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reminder Servis Berkala</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <?php include 'include/header.php'; ?>
</head>


<body>
    <?php include 'include/navbar.php'; ?>

    <div class="container mt-4 mb-4">
        <?php
        while ($user_data = mysqli_fetch_array($result)) {

            $noPolisi = $user_data['noPolisi'];
            $deliveryDate = $user_data['deliveryDate'];
            $tglServisTerakhir = $user_data['tglServisTerakhir'];
            $tglServisSelanjutnya = $user_data['tglServisSelanjutnya'];
            $nama = $user_data['nama'];
            $telepon = $user_data['telepon'];
            $alamat = $user_data['alamat'];
            // due date
            $diff = abs(strtotime($date) - strtotime($tglServisSelanjutnya));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            //printf("%d years, %d months, %d days\n", $years, $months, $days);
            $date1 = date_create($date);
            $date2 = date_create($tglServisSelanjutnya);
            $diff2 = date_diff($date1, $date2);
            //echo $diff->format("%R%a days");
            //update pelanggan set nama  = 'Jehuda Siahaya', alamat = 'Jln. Yabansai, No 3 Perumnas 1 Waena' where id = 1
        }
        ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking Servis</li>
            </ol>
        </nav>


        <div class="container">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Nama</strong> dan <strong>No Telepon</strong> booking (pemesan) bisa berbeda dari data pemilik kendaraan. Jika <strong>Nama</strong> dan
                <strong>No Telepon</strong> pemesan sama dengan data pemilik kendaraan, maka langsung input <strong>Tanggal Servis</strong> dan <strong>Jam Servis</strong> yang dibooking oleh pelanggan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="col-sm mt-4">
                <div class="row">
                    <div class="col">
                        <h5>Data Booking </h5>
                        <form action="" id="fupForm" name="form1" method="post">
                            <input class="form-control form-insert" type="text" id="namaBooking" name="namaBooking" value="<?php echo $nama ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Input nama booking (pemesan)">
                            <input class="form-control form-insert" type="text" id="noTeleponBooking" name="noTeleponBooking" value="<?php echo $telepon ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Input no telepon booking (pemesan)">

                            <label for="tglBeli">Tanggal Servis:</label><br>
                            <input class="form-control form-insert" type="date" id="tanggalServis" name="tanggalServis" required>

                            <label for="tglBeli">Jam Servis</label><br>
                            <input class="form-control form-insert" type="time" id="jamBooking" name="jamBooking" required>

                            <input type="button" name="submit" class="btn btn-primary" value="Submit" id="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">

                            <!-- Modal sebelum submit -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Apakah data sudah benar?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                            <button type="button" class="btn btn-primary" name="servis" id="servis">Ya</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal sebelum submit -->
                        </form>
                    </div>
                    <div class="col">
                        <h5>Data Pemilik</h5>
                        <form class="form-floating mt-2 col">
                            <input type="text" class="form-control" id="namaPemilik" value="<?php echo $nama ?>" disabled>
                            <label for="namaPemilik">Nama Pemilik</label>
                        </form>
                        <form class="form-floating mt-2 col">
                            <input type="text" class="form-control" id="teleponPemilik" value="<?php echo $telepon ?>" disabled>
                            <label for="teleponPemilik">Telepon</label>
                        </form>
                        <form class="form-floating mt-2 col">
                            <input type="text" class="form-control" id="alamatPemilik" value="<?php echo $alamat ?>" disabled>
                            <label for="alamatPemilik">Alamat</label>
                        </form>
                    </div>
                </div>

                <hr>
                <h5>Data Mobil</h5>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="floatingInputValue" value="<?php echo $noPolisi ?>" disabled>
                    <label for="floatingInputValue">No Polisi</label>
                </form>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="noRangka" value="<?php echo $noRangka ?>" disabled>
                    <label for="floatingInputValue">No Rangka</label>
                </form>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="floatingInputValue" value="<?php echo $deliveryDate ?>" disabled>
                    <label for="floatingInputValue">Tanggal Beli</label>
                </form>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="floatingInputValue" value="<?php echo $tglServisTerakhir ?>" disabled>
                    <label for="floatingInputValue">Servis Terakhir</label>
                </form>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="floatingInputValue" value="<?php echo $tglServisSelanjutnya ?>" disabled>
                    <label for="floatingInputValue">Servis Selanjutnya</label>
                </form>
                <form class="form-floating mt-2 col">
                    <input type="text" class="form-control" id="floatingInputValue" value="<?php echo $diff2->format("%R%a hari ");
                                                                                            printf("(%d bulan, %d hari)", $months, $days); ?>" disabled>
                    <label for="floatingInputValue">Due</label>
                </form>


            </div>

        </div>

    </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#namaBooking').focus();
            var today = moment().format('YYYY-MM-DD');
            $('#tanggalServis').on('change', function() {
                var tglServis = $('#tanggalServis').val();
                if (tglServis <= today) {
                    alert('Tanggal booking tidak valid');
                    $("#tanggalServis").val("")
                    $("#tanggalServis").focus();
                };
            });

            function capitalizeFirstLetters(str) {
                return str.toLowerCase().replace(/^\w|\s\w/g, function(letter) {
                    return letter.toUpperCase();
                })
            }
            $('#namaBooking').on('input', function() {
                kapitalisasi = $('#namaBooking').val();
                x = capitalizeFirstLetters(kapitalisasi);
                $('#namaBooking').val(x)
            });
            $("#noTeleponBooking").autoNumeric('init', {
                aSep: '',
                aDec: '.',
                aForm: true,
                aSign: ' +62',
                pSign: 'p',
                vMax: '9999999999999',
                vMin: '-999999999'
            });

            $('#servis').on('click', function() {
                var namaBooking = $('#namaBooking').val();
                var noTeleponBooking = $('#noTeleponBooking').val();
                var tanggalServis = $('#tanggalServis').val();
                var jamBooking = $('#jamBooking').val();
                var noRangka = $('#noRangka').val();
                if (namaBooking != "" && noTeleponBooking != "" && tanggalServis != "" && jamBooking != "" && noRangka != "") {
                    $.ajax({
                        type: "POST",
                        url: "booking_proses.php",
                        data: {
                            'namaBooking': namaBooking,
                            'noTeleponBooking': noTeleponBooking,
                            'tanggalServis': tanggalServis,
                            'jamBooking': jamBooking,
                            'noRangka': noRangka
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
                                window.location = "list_booking.php";
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

<footer class="footer"></footer>

</html>