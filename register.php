<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Wilco
 * Date: 26/05/17
 * Time: 11:18
 */

require_once 'includes/connect.php';

//er wordt gechekt of een gebruiker al is ingelogd
if (isset($_SESSION['email']) != '')
{
    header('location: flights');
}

if(isset($_POST['submit']))
{

    $nationality = $_POST['nationality'];
    $docunr = $_POST['docunr'];
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $sex = $_POST['sex'];
    $expirationDate = $_POST['expirationDate'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];
    $agree = $_POST['agree'];

    if($agree) {
//        echo('Akkoord gegaan!');

        if($password == $retypePassword) {

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);


            $sql = sprintf("INSERT INTO Traveller(Email, Password, Surname, First_name, Nationality, Date_of_birth, Place_of_birth, sex, DocumentNumber, Date_of_expiration)
                      VALUES ('$email', '$hashPassword', '$surname', '$first_name', '$nationality', '$dob', '$pob', '$sex', '$docunr', '$expirationDate')
                                    ",
                mysqli_real_escape_string($db, $email),
                mysqli_real_escape_string($db, $hashPassword),
                mysqli_real_escape_string($db, $surname),
                mysqli_real_escape_string($db, $first_name),
                mysqli_real_escape_string($db, $nationality),
                mysqli_real_escape_string($db, $dob),
                mysqli_real_escape_string($db, $pob),
                mysqli_real_escape_string($db, $sex),
                mysqli_real_escape_string($db, $docunr),
                mysqli_real_escape_string($db, $expirationDate)
            );

            mysqli_query($db, $sql);
            $_SESSION['email'] = $_POST['email'];
            header('location: flights');
            exit();

        }
        else {
            echo("wachtwoorden matchen niet met elkaar!");
        }

    }
    else {
        echo("U moet akkoord gaan met de voorwaarden!");
    }

}
mysqli_close($db);


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
        <h1>Registreren</h1>

        <p class="black-text">Om te registreren moet je je paspoortgegevens invullen. Wij gaan zorgvuldig om met jouw gegevens.</p>

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
                        <input name="agree" <?php if ($agree) {?> checked <?php } ?> type="checkbox" id="agree" />
                        <label for="agree">
                            <a class="waves-effect waves-light" href="#agreement">Ik ga akkoord met de voorwaarden</a>

                        </label>
                    </div>

                    <div class="input-field col s12 center-align">

                        <button class="btn waves-effect waves-light" type="submit" name="submit">Registeren
                            <i class="material-icons left">trending_flat</i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="agreement" class="modal">
        <div class="modal-content">
            <h4>Voorwaarden</h4>
            <p>* Ik heb mijn gegevens naar waarheid ingevuld.</p>
            <p>* CaBaLaCo verstrekt uw gegevens niet aan derden.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Sluiten</a>
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

