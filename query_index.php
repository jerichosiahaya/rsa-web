<!-- query yang ada pada halaman beranda/index -->
<?php
$incoming = mysqli_query(
    $conn,
    "select pelanggan.id, mobil.noRangka, nama, telepon, noPolisi, tglServisTerakhir, tglServisSelanjutnya, TIMESTAMPDIFF(DAY,curdate(),tglServisSelanjutnya) AS due 
    from pelanggan, mobil, detail_servis 
    where pelanggan.id = mobil.id and mobil.noRangka = detail_servis.noRangka
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
$arr3 = mysqli_fetch_all($book_data, MYSQLI_ASSOC);
$date = date("Y-m-d");
$time = date("H:i");
global $counter;

$data;
$n = 0;

foreach($arr as $x){
    $spec = $n;
    foreach($arr3 as $y){
        if($x['noRangka'] == $y['noRangka']){
            $date1 = date_create($date);
            $date2 = date_create($y['tanggalServis']);
            $diff = date_diff($date1, $date2)->format("%r%a");
            $data[$n] = array(
                'id' => $x['id'],
                'noRangka' => $x['noRangka'],
                'nama' => $x['nama'],
                'telepon' => $x['telepon'],
                'noPolisi' => $x['noPolisi'],
                'tglServisTerakhir' => $x['tglServisTerakhir'],
                'tglServisSelanjutnya' => $x['tglServisSelanjutnya'],
                'due' => $diff,
                'Booking' => $y['tanggalServis']
            );
            
            $n++;
        }
    }

    if($spec == $n){
        $data[$n] = array(
            'id' => $x['id'],
            'noRangka' => $x['noRangka'],
            'nama' => $x['nama'],
            'telepon' => $x['telepon'],
            'noPolisi' => $x['noPolisi'],
            'tglServisTerakhir' => $x['tglServisTerakhir'],
            'tglServisSelanjutnya' => $x['tglServisSelanjutnya'],
            'due' => $x['due'],
            'Booking' => "-"
        );
        $n++;
    }
}


