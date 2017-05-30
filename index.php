<?php

$app_id = "99e00149";
$app_key = "0f48e45ddd236fae49b34b25417606a3";

$app_id = "99e00149";
$app_key = "0f48e45ddd236fae49b34b25417606a3";
$curl = curl_init("https://api.schiphol.nl/public-flights/flights?app_id=99e00149&app_key=0f48e45ddd236fae49b34b25417606a3&flightname=KL1665&includedelays=false&page=0&sort=%2Bscheduletime");

//$curl = curl_init("https://api.schiphol.nl/public-flights/flights?app_id=".$app_id."&app_key=".$app_key);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "resourceversion: v3"
    ),
));
$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_code != 200) {
    echo $http_code . " Error when calling the public flight api: " . $response;
} else {
    $object = json_decode($response, true);

    $flight = $object['flights'][0];
//print_r($flight);
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


<?php

include('includes/header.php');

?>


<div class="slider fullscreen">

    <ul class="slides">
        <li>
            <img src="./images/checkin.jpg"> <!-- random image -->
            <div class="caption center-align">
                <h3>Zorgeloos op reis!</h3>
                <h5 class="light grey-text text-lighten-3">Het is nog nooit zo makkelijk geweest je koffer in te checken! Ontdek wat CaBaLaCo voor jou doet!</h5>
            </div>
        </li>
        <li>
            <img src="./images/entrance.jpg"> <!-- random image -->
            <div class="caption center-align">
                <h3>Geen Stress!</h3>
                <h5 class="light grey-text text-lighten-3">Check je koffer bij aankomst van het vliegveld in.</h5>
            </div>
        </li>
        <li>
            <img src="./images/queue.jpg"> <!-- random image -->
            <div class="caption center-align">
                <h3>Geen wachtrij</h3>
                <h5 class="light grey-text text-lighten-3">Is jouw koffer goedgekeurd? Dan kan je zonder te wachten jouw reis vervolgen.</h5>
            </div>
        </li>
        <li>
            <img src="./images/bagalert.png"> <!-- random image -->
            <div class="caption center-align">
                <h3>Weten waar jouw koffer is</h3>
                <h5 class="light grey-text text-lighten-3">Realtime op de hoogte blijven waar jouw koffer zicht bevindt.</h5>
            </div>
        </li>
    </ul>
</div>


<!---->
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
