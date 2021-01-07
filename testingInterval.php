<h2>Modul scheduling</h2>
<!-- 
    - Modul untuk tahu kapan mobil akan diservis
    - Batas sampai 100K lalu balik lagi ke 10K
    - Service 1K interval 1 bulan
    - Bisa dibikin loop?
    - Nanti yang dimunculin di tabel itu service paling dekat (due)
-->
<?php
$dateNow = new DateTime('now');
$service10k = (clone $dateNow)->modify('+6 month');
$service20k = (clone $service10k)->modify('+6 month');
$service30k = (clone $service20k)->modify('+6 month');
$service40k = (clone $service30k)->modify('+6 month');
$service50k = (clone $service40k)->modify('+6 month');
$service60k = (clone $service50k)->modify('+6 month');
$service70k = (clone $service60k)->modify('+6 month');
$service80k = (clone $service70k)->modify('+6 month');
$service90k = (clone $service80k)->modify('+6 month');
$service100k = (clone $service90k)->modify('+6 month');

echo "Today's date: ";
echo $dateNow->format('d-m-Y');
echo "<br> Service 10K: ";
echo $service10k->format('d-m-Y');
echo "<br> Service 20K: ";
echo $service20k->format('d-m-Y');
echo "<br> Service 30K: ";
echo $service30k->format('d-m-Y');
echo "<br> Service 40K: ";
echo $service40k->format('d-m-Y');
echo "<br> Service 50K: ";
echo $service50k->format('d-m-Y');
echo "<br> Service 60K: ";
echo $service60k->format('d-m-Y');
echo "<br> Service 70K: ";
echo $service70k->format('d-m-Y');
echo "<br> Service 80K: ";
echo $service80k->format('d-m-Y');
echo "<br> Service 90K: ";
echo $service90k->format('d-m-Y');
echo "<br> Service 100K: ";
echo $service100k->format('d-m-Y');

echo '<br><br>Loop';
// Lebih efektif pake ini
$nextService2 = (clone $dateNow);
$serviceNo = 10;
echo "<br>Today's date: ";
echo $dateNow->format('d-m-Y');
$service1k = (clone $dateNow)->modify('+1 month');
echo "<br>Service 1K: ";
echo $service1k->format('d-m-Y');
for ($i = 0; $i < 10; $i++) {
    $nextService = (clone $nextService2)->modify('+6 month');
    echo '<br>';
    echo 'Service ';
    echo $serviceNo;
    echo "K: ";
    echo $nextService->format('d-m-Y');
    $nextService2 = (clone $nextService);
    $serviceNo += 10;
}
