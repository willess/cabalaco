<?php
session_start();

require_once 'includes/connect.php';

//er wordt gechekt of een gebruiker al is ingelogd
if (isset($_SESSION['email']) != '')
{
    header('location: flights');
}

if(isset($_POST['submit'])) {

    $email = $_POST['email'];

    $sql = sprintf("SELECT * FROM Traveller WHERE Email = '%s'",
        mysqli_real_escape_string($db, $email)
    );

        $result = mysqli_query($db, $sql);

        $row = mysqli_fetch_assoc($result);

    if($row)
    {
        $hash = $row['Password'];

        if(password_verify($_POST['password'], $hash))
        {
                $_SESSION['email'] = $_POST['email'];
                header('location: flights');
                exit();
        }
        else
        {
            echo 'Combinatie klopt niet';
        }
    }
    else
    {
        echo 'Gebruiker bestaat niet';
    }
}

/**
 * Created by PhpStorm.
 * User: Wilco
 * Date: 26/05/17
 * Time: 11:29
 */

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
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <h2 class="header">Inloggen</h2>

                <form class="col s12" action="" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input value="<?= $email ?>" id="email" type="email" name="email" class="validate" required>
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                        </div>

                        <div class="input-field col s12">
                            <input name="password" id="password" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s12 center-align">

                            <button class="btn waves-effect waves-light" type="submit" name="submit">Inloggen
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

