<?php
session_start();

if (isset($_SESSION['email']) != '') {
    $loggedIn = true;
}
else {
    $loggedIn = false;
}



?>
