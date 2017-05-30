<?php
session_start();

require_once 'includes/connect.php';
require_once 'includes/userCheck.php';

$sql = mysqli_query($db, "SELECT * FROM Flight WHERE traveller_id = '$userId'");
//$row = mysqli_fetch_array($sql, MYSQLI_ASSOC);
while ($row = mysqli_fetch_assoc($sql)) {
    $flights[] = $row;
}

$dateToday = date("Y-m-d");
//echo $dateToday;

foreach ($flights as $flight) {

    if($dateToday == $flight['Date_flight']) {
        $currentFlight = $flight;
    }


//    echo $flight['Destination'];
}

echo $currentFlight['Flightnumber'];
echo $currentFlight['Date_flight'];
echo $currentFlight['Destination'];



//echo $flights[0]['Id'];

echo '<script>';
echo 'console.log('. json_encode( $flights ) .')';
echo '</script>';

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


<?php

include('includes/header.php');

?>

<div class="container">

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a href="#past">Geweest</a></li>
                <li class="tab col s4"><a class="active" href="#current">Huidige</a></li>
                <li class="tab col s4"><a href="#future">Komende</a></li>
            </ul>
        </div>
        <div id="past" class="col s12">Jouw vorige vluchten</div>
        <div id="current" class="col s12">
            <h1>Huidige Reis</h1>

            <h3>Vluchtnummer: <?= $currentFlight['Flightnumber']; ?></h3>
            <h4>VertrekDatum: <?= $currentFlight['Date_flight']; ?></h4>
            <h4>Bestemming: <?= $currentFlight['Destination']; ?></h4>
        </div>
        <div id="future" class="col s12">Komende vluchten</div>
    </div>

</div>




<?php
//
//include('includes/footer.php');
//
//?>



<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
