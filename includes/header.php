<?php
/**
 * Created by PhpStorm.
 * User: Wilco
 * Date: 26/05/17
 * Time: 10:50
 */
require_once 'checkLogin.php';

?>

<header>

    <div class="navbar-fixed">
        <nav role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="./" class="brand-logo black-text">CaBaLaCo</a>
                <ul class="right hide-on-med-and-down">
                    <div class="col hide-on-small-only m3 l2">
                        <ul class="right hide-on-med-and-down">
                            <?php if($loggedIn) { ?>
                            <li><a href="addFlight">Vlucht toevoegen</a></li>
                            <li><a href="flights">Mijn vluchten</a></li>
                            <li><a href="profile">Mijn profiel</a></li>
                            <li><a href="logout">Uitloggen</a></li>
                            <?php } else { ?>
                            <li><a href="login">Inloggen</a></li>
                            <li><a href="register">Registreren</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </ul>


                <ul id="slide-out" class="side-nav">
                    <?php if($loggedIn) { ?>

                    <li><div class="userView">
                            <div class="background black">
<!--                                <img src="../images/checkin.jpg">-->
                            </div>

                            <a href="#!name"><span class="white-text name"><?= $user['First_name'] ?></span></a>
                            <a href="#!email"><span class="white-text email"><?= $user['Email'] ?></span></a>
                        </div></li>
                        <li><a class="waves-effect" href="./">Home</a></li>
                        <li><a class="waves-effect" href="addFlight">Vlucht toevoegen</a></li>
                        <li><a class="waves-effect" href="flights">Mijn vluchten</a></li>
                        <li><a class="waves-effect" href="profile">Mijn profiel</a></li>
                        <li><a class="waves-effect" href="logout">Uitloggen</a></li>

                    <?php } else { ?>
                        <li><a class="waves-effect" href="./">Home</a></li>
                        <li><a class="waves-effect" href="login">Inloggen</a></li>
                        <li><a class="waves-effect" href="register">Registreren</a></li>
                    <?php } ?>



<!--                    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>-->
<!--                    <li><a href="#!">Second Link</a></li>-->
<!--                    <li><div class="divider"></div></li>-->
<!--                    <li><a class="subheader">Subheader</a></li>-->
<!--                    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>-->
                </ul>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>
    </div>

</header>
