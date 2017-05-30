<?php
session_start();

//gebruikersnaam van de sessie wordt in een variabale gezet
$user_check = $_SESSION['email'];

$sql = mysqli_query($db, "SELECT * FROM Traveller WHERE Email = '$user_check'");

$row = mysqli_fetch_array($sql, MYSQLI_ASSOC);

$user = $row;
$userId = $user['Id'];
if(!isset($user_check))
{
    header('location: index');
}



?>
