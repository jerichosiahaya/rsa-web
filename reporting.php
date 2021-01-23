<?php
include_once("include/config.php");
$done = mysqli_query(
    $conn,
    "select pelanggan.nama, pelanggan.id, pelanggan.telepon, pelanggan.alamat, mobil.noMesin, mobil.id, mobil.noPolisi, riwayat.noRangka, riwayat.kilometer, riwayat.tanggalServis, riwayat.namaBooking, riwayat.noTeleponBooking, riwayat.jamBooking from pelanggan, mobil, riwayat 
    where mobil.noRangka = riwayat.noRangka and mobil.id = pelanggan.id and riwayat.done = 1 
    ORDER BY tanggalServis ASC"
);
date_default_timezone_set('Asia/Jayapura');
$date = date("Y-m-d");
$arr3 = mysqli_fetch_all($done, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting | RSA</title>
    <?php
    include 'include/header.php';
    ?>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container mt-4">
        <div class="alert alert-info mb-4" role="alert">
            Semua data riwayat servis. Filter data menggunakan fitur filter di atas kolom yang ingin difilter.
        </div>
        <table class="table is-bordered table-hover tableData" id="example">
            <thead>
                <tr>
                    <th>Nama Pemesan</th>
                    <th>Telepon Pemesan</th>
                    <th>No Polisi</th>
                    <th>Tanggal Servis</th>
                    <!-- <th>Jam Servis</th> -->
                    <th>Kilometer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($arr3 as $user_data) {
                    echo "<tr>";
                    echo "<td>" . $user_data['namaBooking'] . "</td>";
                    echo "<td>" . $user_data['noTeleponBooking'] . "</td>";
                    echo "<td>" . $user_data['noPolisi'] . "</td>";
                    echo "<td>" . date('d-m-Y', strtotime($user_data['tanggalServis'])) . "</td>";
                    //echo "<td>" . $user_data['jamBooking'] . "</td>";
                    echo "<td>" . $user_data['kilometer'] . "</td>";
                }
                ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary btn-sm mt-3" id="print"><i class="fa fa-print"></i> Print</button>
        <button type="button" class="btn btn-warning btn-sm mt-3" id="excel"><i class="fa fa-file-excel"></i> Export to Excel</button>
    </div>

    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#example thead tr').clone(true).appendTo('#example thead');
            $('#example thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Filter ' + title + '" />');

                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('#print').on('click', function() {
                $('#example').printThis({
                    footer: null,
                    removeScripts: true
                });
            });
            $('#excel').on('click', function() {
                $("#example").table2excel({
                    //exclude: ".excludeThisClass",
                    name: "Worksheet Name",
                    filename: "daftarbooking.xls", // do include extension
                    preserveColors: false // set to true if you want background colors and font colors preserved
                });
            });
        });
    </script>
</body>

</html>