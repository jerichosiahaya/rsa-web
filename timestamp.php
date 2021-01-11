<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Jakarta'); // atau timezone lain
    echo $timestamp = date('H:i:s');
    ?>
    <div id="timestamp"></div>
</body>
<script>
    $(document).ready(function() {
        setInterval(timestamp, 1000);
    });

    function timestamp() {
        $.ajax({
            url: 'http://localhost/projects/reminder-servis/timestamp.php',
            success: function(data) {
                $('#timestamp').html(data);
            },
        });
    }
</script>

</html>