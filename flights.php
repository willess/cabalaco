<?php
session_start();

require_once 'includes/connect.php';
require_once 'includes/userCheck.php';

$sql = mysqli_query($db, "SELECT * FROM Flight WHERE traveller_id = '$userId' ORDER BY Date_flight ASC");
//$row = mysqli_fetch_array($sql, MYSQLI_ASSOC);
while ($row = mysqli_fetch_assoc($sql)) {
    $flights[] = $row;
}

$pastFlights = [];

$futureFlights = [];


$dateToday = date("Y-m-d");

foreach ($flights as $flight) {

    if($dateToday == $flight['Date_flight']) {
        $currentFlight = $flight;
        $destinationRawUrl = rawurlencode($flight['Destination']);
        $api_key = 'cc722908bc2265f3337441afee6fc910';

        $app_id = "99e00149";
        $flight_api_key = "0f48e45ddd236fae49b34b25417606a3";

        $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$api_key.'&text='.$destinationRawUrl.'%20sight&sort=relevance&per_page=5&format=json&nojsoncallback=1';
        $response = json_decode(file_get_contents($url));
        $photo_array = $response->photos->photo;

        $images = [];
        foreach($photo_array as $photo){


            $photo_url = 'https://farm' . $photo->farm . '.staticflickr.com/' . $photo->server . '/' . $photo->id . '_' . $photo->secret . '_b.jpg';
            array_push($images, $photo_url);

        }

        $textUrl = 'http://en.wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles='.$destinationRawUrl.'&format=json&explaintext&redirects&inprop=url&indexpageids';
        $json = file_get_contents($textUrl);
        $textResponse = json_decode($json);
        $pageid = $textResponse->query->pageids[0];
        $cityText = $textResponse->query->pages->$pageid->extract;


        $curl = curl_init("https://api.schiphol.nl/public-flights/flights?app_id=".$app_id."&app_key=".$flight_api_key."&scheduledate=".$currentFlight['Date_flight']."&flightname=".$currentFlight['Flightnumber']."&includedelays=false&page=0&sort=%2Bscheduletime");

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
    }

    if($flight['Date_flight'] > $dateToday) {
        array_push($futureFlights, $flight);
    }

    if($flight['Date_flight'] < $dateToday) {
        array_push($pastFlights, $flight);
    }



}

//echo '<script>';
//echo 'console.log('. json_encode( $response ) .')';
//echo '</script>';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="EditURI" type="application/rsd+xml" href="//www.mediawiki.org/w/api.php?action=rsd" />

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
        <div id="past" class="col s12">
            <h1>Jouw vorige vluchten</h1>

                <div class="row">
                    <?php foreach ($pastFlights as $flight) { ?>
                    <div class="col s12 l6">
                        <div class="card blue-grey darken-1">
                            <div class="card-content white-text">
                                <span class="card-title"><?= $flight['Flightnumber']; ?></span>
                                <span class="card-title"><?= $flight['Date_flight']; ?></span>
                                <span class="card-title"><?= $flight['Destination']; ?></span>
<!--                                <p>I am a very simple card. I am good at containing small bits of information.-->
<!--                                    I am convenient because I require little markup to use effectively.</p>-->
                            </div>
                            <div class="card-action">
<!--                                <a href="#">This is a link</a>-->
<!--                                <a href="#">This is a link</a>-->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
        </div>
        <div id="current" class="col s12">
            <h1>Huidige Reis</h1>


            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-image">
                            <div id="imageSlider" class="slider container">
                                <ul class="slides">

                                    <?php foreach($images as $image) { ?>

                                        <li>
                                            <img src="<?= $image; ?>">
                                        </li>

                                    <?php } ?>

                                </ul>
                            </div>
                        </div>
                        <div id="cityText" class="card-content" hidden>
                            <p><?= $cityText; ?></p>
                        </div>
                        <div class="card-action">

                            <a class="clickForInformation" href="#">Lees meer over <?= $currentFlight['Destination']; ?></a>
                            <a class="clickForInformation" href="#" hidden>Sluiten</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="col s3">
                        <div id="processConfirmed" class="checkIn processTravel">
                            <p class="">Inchecken</p>
                        </div>
                    </div>

                    <div class="col s3">
                        <div class="baggage processTravel">
                            <p class="center-align">Bagage</p>
                        </div>
                    </div>

                    <div class="col s3">
                        <div class="douane processTravel">
                            <p class="center-align lounge">Douane/ Lounge</p>
                        </div>

                    </div>

                    <div class="col s3">
                        <div class="gate processTravel">
                            <p class="center-align">Gate</p>
                        </div>
                    </div>
                </div>
            </div>


            <h3>Vluchtnummer: <?= $currentFlight['Flightnumber']; ?></h3>
            <h4>VertrekDatum: <?= $currentFlight['Date_flight']; ?></h4>
            <h4>Bestemming: <?= $currentFlight['Destination']; ?></h4>
        </div>
        <div id="future" class="col s12">
            <h1>Komende vluchten</h1>
            <div class="row">
                <?php foreach ($futureFlights as $flight) { ?>
                    <div class="col s12 l6">
                        <div class="card blue-grey darken-1">
                            <div class="card-content white-text">
                                <span class="card-title"><?= $flight['Flightnumber']; ?></span>
                                <span class="card-title"><?= $flight['Date_flight']; ?></span>
                                <span class="card-title"><?= $flight['Destination']; ?></span>
                                <!--                                <p>I am a very simple card. I am good at containing small bits of information.-->
                                <!--                                    I am convenient because I require little markup to use effectively.</p>-->
                            </div>
                            <div class="card-action">
<!--                                <a href="#">This is a link</a>-->
<!--                                <a href="#">This is a link</a>-->
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">

    var flightInfoPhp = <?= json_encode($response); ?>;
    var flightInfo = JSON.parse(flightInfoPhp);


    //real Time
    var time = new Date().getTime();
    console.log(time);

    //gate open time
    var gateOpen = Date.parse(flightInfo['flights'][0]['expectedTimeGateOpen']);
    console.log(flightInfo['flights'][0]['expectedTimeGateOpen']);
    console.log(gateOpen);

    //gate Close Time
    var gateClose = Date.parse(flightInfo['flights'][0]['expectedTimeGateClosing']);
    console.log(flightInfo['flights'][0]['expectedTimeGateClosing']);
    console.log(gateClose);

    var checkinTime = Date.parse(flightInfo['flights'][0]['checkinAllocations']['checkinAllocations'][0]['startTime']);
    console.log(checkinTime);


    setInterval(function(){

        time = new Date().getTime();
        console.log(time);

        if(time > checkinTime) {
            //bagage ingecheckt!
            console.log('bagage ingecheckt!');
            var a = document.getElementsByClassName('baggage')[0];
//            console.log(a);
//            var k = a.getElementsByTagName('p')[0].innerHTML = '&#10004;';
//            console.log(k);
            a.setAttribute('id', 'processConfirmed');
        }

        if(time > checkinTime && time < gateOpen) {
            //douane/lounge!
            console.log('douane/lounge!!');
            var b = document.getElementsByClassName('douane')[0];

            b.setAttribute('id', 'currentProcess');
        }
        else if (time > gateOpen) {
            var b = document.getElementsByClassName('douane')[0];
//            console.log(a);
            b.setAttribute('id', 'processConfirmed');
        }

        //go To Gate!
        if(time > gateOpen && time < gateClose) {
            console.log('gate Open!');
            var d = document.getElementsByClassName('gate')[0];
//            console.log(a);
            d.setAttribute('id', 'currentProcess');
        }
        else if (time > gateClose) {
            //gate closed
            console.log('gate Closed!');
            var e = document.getElementsByClassName('gate')[0];
//            console.log(a);
            e.setAttribute('id', 'processConfirmed');
        }
    }, 1000);

    console.log(flightInfo['flights'][0]);

//    console.log(flightInfo['flights'][0]);


</script>




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
