<?php

$a = new DateTime('2021-01-01');
$b = new DateTime('2021-02-02');

echo 'servis terakhir:  ';
echo $a->format('d-m-Y');
echo '<br>';
echo 'servis selanjutnya:   ';
echo $b->format('d-m-Y');

echo '<br>';
echo '<br>';

$x = new DateTime('2021-02-02');
if ($x == $b) {
    $a = (clone $b);
    $b->modify('+6 month');
    echo 'jadwal baru waktu servis selanjutnya sudah dilakukan<br>';
    echo 'servis terakhir:  ';
    echo $a->format('d-m-Y');
    echo '<br>';
    echo 'servis selanjutnya:  ';
    echo $b->format('d-m-Y');
} else {
    echo 'F <br>';
    echo $x->format('d-m-Y');
}
