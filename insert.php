<?php
include_once("config.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Insert Data</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'header.php'; ?>
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
        <form action="" id="fupForm" name="form1" method="post">
            <!-- Pemilik -->
            <small class="text-muted">Data pemilik:</small>
            <input class="form-control form-insert" type="text" id="nama" name="nama" placeholder="Nama">
            <input class="form-control form-insert" type="text" id="alamat" name="alamat" placeholder="Alamat">
            <input class="form-control form-insert" type="text" id="telepon" name="telepon" placeholder="Telepon (Contoh: +6281381669200)">
            <!-- Mobil -->
            <small class="text-muted">Data mobil:</small>
            <input class="form-control form-insert" type="text" id="noPolisi" name="noPolisi" placeholder="No Polisi (Contoh: PA 1963 AU)">
            <input class="form-control form-insert" type="text" id="noMesin" name="noMesin" placeholder="No Mesin">
            <input class="form-control form-insert" type="text" id="noRangka" name="noRangka" placeholder="VIN">
            <input class="form-control form-insert" type="text" id="kilometer" name="kilometer" placeholder="Kilometer">
            <!-- Tanggal -->
            <label for="tglBeli">Tanggal Beli:</label><br>
            <input class="form-control form-insert" type="date" id="tglBeli" name="tglBeli">
            <!-- Hidden alert -->
            <small class="text-muted" id="text-1k" hidden>Servis 1K:</small>
            <div class="alert alert-primary" id="alert-1k" role="alert" hidden></div>
            <!-- Tanggal -->
            <label for="tglServisTerakhir">Tanggal Servis Terakhir: </label><br>
            <input class="form-control form-insert" type="date" id="tglServisTerakhir" name="tglServisTerakhir">
            <label for="tglServisTerakhir">Tanggal Servis Selanjutnya: <bdo class="optional-text">(optional)</bdo> </label><br>
            <input class="form-control form-insert" type="date" id="tglServisSelanjutnya" name="tglServisSelanjutnya">
            <!-- Button -->
            <input type="button" name="hapus" class="btn btn-info" value="Hapus" id="hapus">
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

            // kapitalisasi setiap kata
            function capitalizeFirstLetters(str) {
                return str.toLowerCase().replace(/^\w|\s\w/g, function(letter) {
                    return letter.toUpperCase();
                })
            }
            $("#telepon").autoNumeric('init', {
                aSep: '',
                aDec: '.',
                aForm: true,
                aSign: ' +62',
                pSign: 'p',
                vMax: '9999999999999',
                vMin: '-999999999'
            });
            $('#nama').on('input', function() {
                kapitalisasi = $('#nama').val();
                x = capitalizeFirstLetters(kapitalisasi);
                $('#nama').val(x)
            });
            $('#noPolisi').on('input', function(evt) {
                $(this).val(function(_, val) {
                    return val.toUpperCase();
                });
            });
            $('#noMesin').on('input', function(evt) {
                $(this).val(function(_, val) {
                    return val.toUpperCase();
                });
            });
            $('#noRangka').on('input', function(evt) {
                $(this).val(function(_, val) {
                    return val.toUpperCase();
                });
            });
            $('#noRangka').on('change', function() {
                cekValid = $('#noRangka').val().length;
                if (cekValid < 17) {
                    alert('Digit VIN kurang');
                    $('#noRangka').focus();
                }
            });
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
                //alert(b);
                //alert($('#kilometer').val());
            });
            $('#tglBeli').on('change', function() {
                var tglBeli = $("#tglBeli").val();
                var servis1K = moment(tglBeli);
                var v = servis1K.add(1, 'months').locale('id').format('LL');
                //var v = "Jika mobil "
                $("#alert-1k").removeAttr("hidden");
                $("#text-1k").removeAttr("hidden");
                $("#alert-1k").text(v);
            });
            $('#tglServisTerakhir').on('change', function() {
                var tglBeli = $("#tglBeli").val();
                var tglServisTerakhir = $("#tglServisTerakhir").val();
                var a = moment(tglBeli);
                var b = moment(tglServisTerakhir);
                if (tglBeli == tglServisTerakhir) {
                    var startDate = $("#tglServisTerakhir").val();
                    var endDateMoment = moment(startDate); // moment(...) can also be used to parse dates in string format
                    var x = endDateMoment.add(1, 'months').format('YYYY-MM-DD');
                    $("#tglServisSelanjutnya").val(x);
                } else if (b < a) {
                    alert('Tanggal servis tidak boleh sebelum tanggal beli');
                    var tglServisTerakhir = $("#tglServisTerakhir").val("");
                } else {
                    var startDate = $("#tglServisTerakhir").val();
                    var endDateMoment = moment(startDate); // moment(...) can also be used to parse dates in string format
                    var x = endDateMoment.add(6, 'months').format('YYYY-MM-DD');
                    $("#tglServisSelanjutnya").val(x);
                }
                /*
                var startDate = $("#tglServisTerakhir").val();
                var endDateMoment = moment(startDate); // moment(...) can also be used to parse dates in string format
                var x = endDateMoment.add(6, 'months').format('YYYY-MM-DD');
                $("#tglServisSelanjutnya").val(x);
                */
            });
            $('#hapus').on('click', function() {
                $("#nama").val("");
                $("#alamat").val("");
                $("#telepon").val("");
                $("#noRangka").val("");
                $("#noPolisi").val("");
                $("#noMesin").val("");
                $("#tglServisTerakhir").val("");
                $("#tglServisSelanjutnya").val("");
                $("#tglBeli").val("");
            });
            $('#simpan').on('click', function() {
                /*
                $("#nama").attr("disabled", "disabled");
                $("#alamat").attr("disabled", "disabled");
                $("#telepon").attr("disabled", "disabled");
                $("#noRangka").attr("disabled", "disabled");
                $("#noPolisi").attr("disabled", "disabled");
                $("#tglServisTerakhir").attr("disabled", "disabled");
                $("#tglServisSelanjutnya").attr("disabled", "disabled");
                $("#tglBeli").attr("disabled", "disabled");
                $("#simpan").attr("disabled", "disabled");
                */
                var nama = $('#nama').val();
                var alamat = $('#alamat').val();
                var telepon = $('#telepon').val();
                var noRangka = $('#noRangka').val();
                var noPolisi = $('#noPolisi').val();
                var noMesin = $('#noMesin').val();
                var kilometer = $('#kilometer').val().replace(/,| KM/g, "");
                var tglServisTerakhir = $('#tglServisTerakhir').val();
                var tglServisSelanjutnya = $('#tglServisSelanjutnya').val();
                var tglBeli = $('#tglBeli').val();
                /*
                if (tglServisTerakhir == "") {
                    // kalo tgl servis terakhir kosong, maka yang dimasukkin itu tgl beli
                    // kalo tgl servis selanjutnya kosong, maka yang dimasukkin itu tgl beli + 6 bulan
                    var y = moment(tglBeli).format('YYYY-MM-DD');
                    var z = moment(tglBeli).add(6, 'months').format('YYYY-MM-DD');
                    alert("Mobil belum pernah melakukan servis");
                } else {
                    // kalo tidak kosong ya masukin seperti biasa
                    var y = tglServisTerakhir;
                    var z = tglServisSelanjutnya;
                    alert(y + z);
                }
                */
                if (nama != "" && alamat != "" && telepon != "" && noRangka != "" && noMesin != "" && noPolisi != "" && tglBeli != "") {
                    $.ajax({
                        type: "POST",
                        url: "insert_proses.php",
                        data: {
                            'nama': nama,
                            'alamat': alamat,
                            'telepon': telepon,
                            'noRangka': noRangka,
                            'noPolisi': noPolisi,
                            'noMesin': noMesin,
                            'kilometer': kilometer,
                            'tglServisTerakhir': tglServisTerakhir,
                            'tglServisSelanjutnya': tglServisSelanjutnya,
                            'tglBeli': tglBeli,
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
