<?php
include_once("config.php");
$result = mysqli_query(
    $conn, "select noRangka, tanggalServis, namaBooking,  noTeleponBooking, jamBooking, status from riwayat ORDER BY tanggalServis ASC");

    date_default_timezone_set('Asia/Jayapura');
    $date = date("Y-m-d");

    $arr = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    ?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reminder Servis Berkala</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?> 
</head>


<body>
    <?php include 'navbar.php'; ?>


    <div class="container mt-4"> 
        <div class="tab-content" id="myTabContent">

            <!-- Incoming Content -->
            <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                <br>
                <table class="table is-bordered" id="tabel-data">
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
                        $noHp = '+6285244449300';
                        foreach ($arr as $user_data) {
                        
                            $highlight_css = "";
                            $button_css = "btn btn-info";
                        
                            echo "<tr class = '$highlight_css'>";
                            echo "<td>" . $user_data['namaBooking'] . "</td>";
                            echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                            echo "<td>" . $user_data['tanggalServis'] . "</td>";
                            echo "<td>" . $user_data['jamBooking'] . "</td>";
                            echo "<td>" . $user_data['noRangka'] . "</td>";
                            echo "<td>" . $user_data['status'] . "</td>";
                        

                        }
                    
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</body>
