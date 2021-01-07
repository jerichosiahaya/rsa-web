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
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
        <form action="" id="fupForm" name="form1" method="post">
            <!--<input class="form-control" type="text" id="nama" name="nama" placeholder="Nama">-->
            <input type="text" id="nama" name="nama" placeholder="Nama"> <br>
            <input type="text" id="alamat" name="alamat" placeholder="Alamat"> <br>
            <input type="text" id="telepon" name="telepon" placeholder="Telepon"> <br>
            <input type="text" id="noRangka" name="noRangka" placeholder="No Rangka"> <br>
            <input type="text" id="noPolisi" name="noPolisi" placeholder="No Polisi"> <br>
            <label for="tglBeli">Tanggal Beli:</label><br>
            <input type="date" id="tglBeli" name="tglBeli" placeholder="Tanggal Beli"> <br>
            <label for="tglServisTerakhir">Tanggal Servis Terakhir:</label><br>
            <input type="date" id="tglServisTerakhir" name="tglServisTerakhir" placeholder="Servis Terakhir"> <br>
            <label for="tglServisSelanjutnya">Tanggal Servis Selanjutnya:</label><br>
            <input type="date" id="tglServisSelanjutnya" name="tglServisSelanjutnya" placeholder="Servis Selanjutnya"> <br>
            <input type="button" name="hapus" class="btn btn-primary" value="Hapus" id="hapus">
            <input type="button" name="simpan" class="btn btn-primary" value="Simpan" id="simpan">
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#hapus').on('click', function() {
                $("#nama").val("");
                $("#alamat").val("");
                $("#telepon").val("");
                $("#noRangka").val("");
                $("#noPolisi").val("");
                $("#tglServisTerakhir").val("");
                $("#tglServisSelanjutnya").val("");
                $("#tglBeli").val("");
            });
            $('#simpan').on('click', function() {
                $("#nama").attr("disabled", "disabled");
                $("#alamat").attr("disabled", "disabled");
                $("#telepon").attr("disabled", "disabled");
                $("#noRangka").attr("disabled", "disabled");
                $("#noPolisi").attr("disabled", "disabled");
                $("#tglServisTerakhir").attr("disabled", "disabled");
                $("#tglServisSelanjutnya").attr("disabled", "disabled");
                $("#tglBeli").attr("disabled", "disabled");
                $("#simpan").attr("disabled", "disabled");
                var nama = $('#nama').val();
                var alamat = $('#alamat').val();
                var telepon = $('#telepon').val();
                var noRangka = $('#noRangka').val();
                var noPolisi = $('#noPolisi').val();
                var tglServisTerakhir = $('#tglServisTerakhir').val();
                var tglServisSelanjutnya = $('#tglServisSelanjutnya').val();
                var tglBeli = $('#tglBeli').val();
                //alert(sl);
                if (nama != "" && alamat != "" && telepon != "" && noRangka != "" && noPolisi != "" && tglServisTerakhir != "" && tglServisSelanjutnya != "" && tglBeli != "") {
                    //alert(id);
                    //alert(nama);
                    //alert(telepon);
                    //alert(alamat);
                    $.ajax({
                        type: "POST",
                        url: "insert_proses.php",
                        //dataType: 'json',
                        data: {
                            'nama': nama,
                            'alamat': alamat,
                            'telepon': telepon,
                            'noRangka': noRangka,
                            'noPolisi': noPolisi,
                            'tglServisTerakhir': tglServisTerakhir,
                            'tglServisSelanjutnya': tglServisSelanjutnya,
                            'tglBeli': tglBeli,
                        },
                        cache: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                $("#butsave").removeAttr("disabled");
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
                    //$("#butsave").removeAttr("disabled");
                }
            });
        });
    </script>
</body>

</html>