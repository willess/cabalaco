<?php
session_start();

require_once 'includes/connect.php';
require_once 'includes/userCheck.php';

$sql = mysqli_query($db, "SELECT * FROM Traveller WHERE id = '$userId'");
$user = mysqli_fetch_assoc($sql);

$nationality = $user['Nationality'];
$docunr = $user['Documentnumber'];
$first_name = $user['First_name'];
$surname = $user['Surname'];
$dob = $user['Date_of_birth'];
$pob = $user['Place_of_birth'];
$sex = $user['sex'];
$expirationDate = $user['Date_of_expiration'];

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
        <h1>Mijn profiel</h1>

        <p class="black-text">Verander je paspoort gegevens.</p>

        <div class="emptyForm">
            <form class="col s12" action="" method="post">
                <div class="row">

                    <div class="input-field col s12 m6">
                        <input value="<?= $nationality ?>" id="nationality" name="nationality" type="text" class="validate" required />
                        <label for="nationality">Nationaliteit</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $docunr ?>" id="docuNumber" name="docunr" type="text" class="validate" required />
                        <label for="docuNumber">DocumentNummer</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $first_name ?>" id="first_name" name="first_name" type="text" class="validate" required />
                        <label for="first_name">Voornaam</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $surname ?>" id="surname" name="surname" type="text" class="validate" required />
                        <label for="surname">Achternaam</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $dob ?>" id="date" type="date" name="dob" class="datepicker" />
                        <label for="date">Geboortedatum</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $pob ?>" id="placeOfBirth" name="pob" type="text" class="validate" required />
                        <label for="placeOfBirth">Geboorteplaats</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="sex" required>
                            <option value="<?= $sex ?>" disabled selected><?php if($sex != "") { echo($sex); } else { echo("Kies geslacht"); } ?></option>
                            <option value="man">Man</option>
                            <option value="woman">Vrouw</option>
                        </select>
                        <label>Geslacht</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input value="<?= $expirationDate ?>" id="expirationDate" name="expirationDate" type="date" class="datepicker2" />
                        <label for="expirationDate">Geldig tot</label>
                    </div>

                    <p class="col s12">Inloggegevens</p>


                    <div class="input-field col s12">
                        <input value="<?= $email ?>" id="email" type="email" name="email" class="validate" required />
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="password" name="password" type="password" class="validate" required />
                        <label for="password">Wachtwoord</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="password" name="retypePassword" type="password" class="validate" required />
                        <label for="password">Herhaal wachtwoord</label>
                    </div>

                    <div class="input-field col s12 center-align">

                        <button class="btn waves-effect waves-light" type="submit" name="submit">Opslaan
                            <i class="material-icons left">trending_flat</i>
                        </button>
                    </div>

                </div>
            </form>
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
