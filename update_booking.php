<?php
include_once("include/config.php");
global $noRangka;
$date = date("Y-m-d");
$noRangka = $_GET['noRangka'];
$result = mysqli_query($conn, "select * from riwayat where riwayat.noRangka = '$noRangka' and status = 2 and done = 0");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update Booking | Reminder Servis Application</title>
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
            $tanggalServis = $user_data['tanggalServis'];
            $namaBooking = $user_data['namaBooking'];
            $noTeleponBooking = $user_data['noTeleponBooking'];
            $jamBooking = $user_data['jamBooking'];
            $status = $user_data['status'];
            $done = $user_data['done'];
        }
        ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="list_booking.php">List Booking</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Booking</li>
            </ol>
        </nav>


        <div class="container">

            <div class="col-sm mt-4">
                <h5>Data Booking </h5>
                <form action="" id="fupForm" name="form1" method="post">
                    <input class="form-control form-insert" type="text" id="noRangka" name="noRangka" value="<?php echo $noRangka; ?>" hidden>
                    <input class="form-control form-insert" type="text" id="namaBooking" name="namaBooking" value="<?php echo $namaBooking; ?>" disabled>
                    <input class="form-control form-insert" type="text" id="noTeleponBooking" name="noTeleponBooking" value="<?php echo $noTeleponBooking; ?>" disabled>

                    <div class="alert alert-warning mt-4" role="alert">
                        Ubah tanggal atau jam booking
                    </div>

                    <label for="tanggalServis">Tanggal Booking:</label><br>
                    <input class="form-control form-insert" type="date" id="tanggalServis" name="tanggalServis">

                    <label for="jamBooking">Jam Booking</label><br>
                    <input class="form-control form-insert" type="time" id="jamBooking" name="jamBooking">

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
                                    <button type="button" class="btn btn-primary" name="bookingUpdate" id="bookingUpdate">Ya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal sebelum submit -->
                </form>
            </div>

        </div>

    </div>

    </div>
    <script>
        $(document).ready(function() {
            var today = moment().format('YYYY-MM-DD');
            $('#tanggalServis').on('change', function() {
                var tglServis = $('#tanggalServis').val();
                if (tglServis <= today) {
                    alert('Tanggal booking tidak valid');
                    $("#tanggalServis").val("")
                    $("#tanggalServis").focus();
                };
            });
            $('#bookingUpdate').on('click', function() {
                var tanggalServis = $('#tanggalServis').val();
                var jamBooking = $('#jamBooking').val();
                var noRangka = $('#noRangka').val();
                if (tanggalServis != "" && jamBooking != "" && noRangka != "") {
                    $.ajax({
                        type: "POST",
                        url: "update_booking_proses.php",
                        data: {
                            'tanggalServis': tanggalServis,
                            'jamBooking': jamBooking,
                            'noRangka': noRangka,
                        },
                        cache: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                alert("Sukses mengubah data tanggal/jam booking!");
                                window.location = "list_booking.php";
                            } else if (dataResult.statusCode == 201) {
                                alert("Error occured!");
                            }

                        }
                    });
                } else {
                    alert('Please fill all the field!');
                }
            });
        });
    </script>
</body>

<footer class="footer"></footer>

</html>