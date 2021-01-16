<!-- query yang ada pada halaman beranda/index -->
<?php
$incoming = mysqli_query(
    $conn,
    "select pelanggan.id, mobil.noRangka, nama, telepon, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
    from pelanggan, mobil, detail_servis 
    where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka and TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) >= 0
    ORDER BY tglServisSelanjutnya ASC"
);

$overdue = mysqli_query(
    $conn,
    "select pelanggan.id, mobil.noRangka, nama, telepon, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
    from pelanggan, mobil, detail_servis 
    where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka and TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) < 0
    ORDER BY tglServisSelanjutnya ASC"
);

$book_data = mysqli_query(
    $conn,
    "select noRangka, tanggalServis, namaBooking, noTeleponBooking, jamBooking, done
    from riwayat 
    where status = 2 and done = 0"
);
date_default_timezone_set('Asia/Jayapura');
$arr = mysqli_fetch_all($incoming, MYSQLI_ASSOC);
$arr2 = mysqli_fetch_all($overdue, MYSQLI_ASSOC);
$arr3 = mysqli_fetch_all($book_data, MYSQLI_ASSOC);
$date = date("Y-m-d");
$time = date("H:i");
