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
    }

    if($flight['Date_flight'] > $dateToday) {
        array_push($futureFlights, $flight);
    }

    if($flight['Date_flight'] < $dateToday) {
        array_push($pastFlights, $flight);
    }

}

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
