<?php
include_once("include/config.php");
global $id, $noRangka;
$id = $_GET['id'];
$noRangka = $_GET['noRangka'];
$result = mysqli_query($conn, "select nama, alamat, telepon, noPolisi, deliveryDate, detail_servis.noRangka, tglServisTerakhir, tglServisSelanjutnya 
from pelanggan, mobil, detail_servis 
where pelanggan.id = $id and mobil.noRangka = '$noRangka' and mobil.noRangka = detail_servis.noRangka 
ORDER BY tglServisSelanjutnya ASC");
// update detail_servis set detail_servis.tglServisTerakhir = '2020-12-28', detail_servis.tglServisSelanjutnya = '2021-02-12' where detail_servis.noRangka = '214253MH6975D'
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Tanggal | RSA Web</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'include/header.php'; ?>
</head>

<body>
    <?php require 'include/navbar.php'; ?>
    <div class="container mt-5">

        <?php
        while ($user_data = mysqli_fetch_array($result)) {
            $nama = $user_data['nama'];
            $alamat = $user_data['alamat'];
            $telepon = $user_data['telepon'];
            $noPolisi = $user_data['noPolisi'];
            $tglBeli = $user_data['deliveryDate'];
            $tglServisTerakhir = date("d-m-Y", strtotime($user_data['tglServisTerakhir']));
            $tglServisSelanjutnya = date("d-m-Y", strtotime($user_data['tglServisSelanjutnya']));
        }
        ?>

        <form id="fupForm" name="form1" method="post">
            <div class="row">
                <label for="fname">Servis terakhir: (<?php echo  $tglServisTerakhir;  ?>)</label><br>
                <div class="col mt-2">
                    <input type="date" class="form-control" id="st" name="st"><br>
                </div>
            </div>
            <div class="row">
                <label for="lname">Servis selanjutnya: (<?php echo  $tglServisSelanjutnya;  ?>)</label><br>
                <div class="col mt-2">
                    <input type="date" class="form-control" id="sl" name="sl"><br><br>
                </div>
            </div>
            <input type="button" name="save" class="btn btn-primary" value="Simpan" id="butsave">
            <input type="hidden" id="nr" name="nr" value=" <?php echo $noRangka; ?> ">
        </form>

    </div>
    <script>
        $(document).ready(function() {
            $('#butsave').on('click', function() {
                $("#butsave").attr("disabled", "disabled");
                var st = $('#st').val();
                var sl = $('#sl').val();
                var nr = "<?php echo $noRangka; ?>";
                //alert(sl);
                if (st != "" && sl != "" && nr != "") {
                    //alert($('#nr').val());
                    $.ajax({
                        type: "POST",
                        url: "edit_proses.php",
                        //dataType: 'json',
                        data: {
                            'st': st,
                            'sl': sl,
                            'nr': nr,
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
                    //$("#butsave").removeAttr("disabled");
                }
            });
        });
    </script>
</body>

</html>