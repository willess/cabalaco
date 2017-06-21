<?php

session_start();

require_once 'includes/connect.php';
require_once 'includes/userCheck.php';

$sql = mysqli_query($db, "SELECT * FROM Flight WHERE traveller_id = '$userId' ORDER BY Date_flight ASC");
//$row = mysqli_fetch_array($sql, MYSQLI_ASSOC);
while ($row = mysqli_fetch_assoc($sql)) {
    $flights[] = $row;
}

$dateToday = date("Y-m-d");

foreach ($flights as $flight) {

    if($dateToday == $flight['Date_flight']) {
        $currentFlight = $flight;

//        echo '<script>';
//        echo 'console.log('. json_encode( $currentFlight ) .')';
//        echo '</script>';

    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/main.css" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CaBaLaCo</title>
</head>

<body>

<div class="labelBox z-depth-3">

    <div class="strepen"></div>

    <h4 class="center-align"><?= $user['First_name']." ".$user['Surname']; ?></h4>
    <p class="center-align">Bestemming: <span class="labelDestination"><?= $currentFlight['Destination']; ?></span></p>
    <p class="center-align">Datum van vertrek: <span class="labelDateFlight"><?= $currentFlight['Date_flight']; ?></span></p>
    <p class="center-align">Vluchtnummer: <span class="labelFlightNumber"><?= $currentFlight['Flightnumber']; ?></span></p>

    <div class="labels">
        <svg id="code128"></svg>
        <svg class="labelRotate" id="code129"></svg>
    </div>



</div>


<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript">

    JsBarcode("#code128", ["<?= $user['Id']; ?>", " <?= $currentFlight['Flightnumber']; ?>"]);
    JsBarcode("#code129", ["<?= $user['Id']; ?>", " <?= $currentFlight['Flightnumber']; ?>"]);

    var a = document.getElementById('code128');
        a.style.transform = "rotate(90deg)";

</script>
</body>
</html>
