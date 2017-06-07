<?php
session_start();

require_once 'includes/connect.php';
require_once 'includes/userCheck.php';

//echo $user['Email'];

if(isset($_GET['submit']))
{
    $flightNumber = strtoupper($_GET['flightNumber']);
    $departureDate = strtoupper($_GET['departureDate']);

    if($departureDate != '') {
        $app_id = "99e00149";
        $app_key = "0f48e45ddd236fae49b34b25417606a3";

        $app_id = "99e00149";
        $app_key = "0f48e45ddd236fae49b34b25417606a3";
        $curl = curl_init("https://api.schiphol.nl/public-flights/flights?app_id=99e00149&app_key=0f48e45ddd236fae49b34b25417606a3&scheduledate=".$departureDate."&flightname=".$flightNumber."&includedelays=false&page=0&sort=%2Bscheduletime");

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

            $flightSearchTrue = true;
            $flight = $object['flights'][0];
//            echo $flight['route']['destinations'][0];

            $curl = curl_init("https://api.schiphol.nl/public-flights/destinations/".$flight['route']['destinations'][0]."?app_id=99e00149&app_key=0f48e45ddd236fae49b34b25417606a3");
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "resourceversion: v1"
                ),
            ));
            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $object = json_decode($response, true);
//            echo $object['country'];




//          echo $flight['flightName'];
//          echo $flight['scheduleDate'];
//          echo $flight['route']['destinations'][0];

//          print_r($flight);
        }
    }


}

if(isset($_POST['submit']))
{
//    echo 'test';

    $flightNr = $_POST['flightNr'];
    $scheduleDate = $_POST['scheduleDate'];
    $destination = $_POST['destination'];
    $userId = $user['Id'];

//    echo $flightNr;
//    echo $scheduleDate;
//    echo $destination;
//    echo $userId;
//
//    echo $user['Email'];

    $sql = sprintf("INSERT INTO Flight(traveller_id, Flightnumber, Date_flight, Destination)
                      VALUES ('$userId', '$flightNr', '$scheduleDate', '$destination')
                                    ",
        mysqli_real_escape_string($db, $userId),
        mysqli_real_escape_string($db, $flightNr),
        mysqli_real_escape_string($db, $scheduleDate),
        mysqli_real_escape_string($db, $destination)
    );
    mysqli_query($db, $sql);

    header('location: flights');
    exit();
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

<div class="container">

    <div class="row">
        <form class="col s12 z-depth-4" method="get" action="">
            <h1>Vlucht toevoegen</h1>

            <div class="input-field col s12 m6">
                <input value="<?= $flightNumber ?>" id="search" class="searchFlight" type="search" name="flightNumber" placeholder="vluchtnummer" onkeypress="return RestrictSpace()" style="text-transform:uppercase" required/>
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
            <div class="input-field col s12 m6">
                <input id="date" type="date" name="departureDate" class="datepicker" required />
                <label for="date">Datum van vertrek</label>
            </div>
            <div class="input-field col s12 center-align">

                <button class="btn waves-effect waves-light" type="submit" name="submit">Zoeken
                    <i class="material-icons left">trending_flat</i>
                </button>
            </div>

        </form>
    </div>

    <?php if($flightSearchTrue) { ?>

        <h3>Is dit jouw vlucht?</h3>

        <div class="row">
            <form class="col s12" method="post" action="">
                <div class="input-field col s12 m4">
                    <input class="disabled" value="<?= $flight['flightName'] ?>" id="flightNumber" type="text" name="flightNr" />
                    <label for="flightNumber">Vluchtnummer</label>
                </div>

                <div class="input-field col s12 m4">
                    <input class="disabled" value="<?= $flight['scheduleDate'] ?>" id="scheduleDate" type="text" name="scheduleDate" />
                    <label for="scheduleDate">Vertrekdatum</label>
                </div>

                <div class="input-field col s12 m4">
                    <input class="disabled" value="<?= $object['city']; ?>" id="destination" type="text" name="destination" />
                    <label for="destination">Bestemming</label>
                </div>

                <div class="input-field col s12 center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="submit">Vlucht toevoegen
                        <i class="material-icons left">trending_flat</i>
                    </button>
                </div>


            </form>
        </div>

    <?php } ?>

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
<script type="text/javascript">
    function RestrictSpace() {
        if (event.keyCode == 32) {
            return false;
        }
    }
</script>
</body>
</html>
