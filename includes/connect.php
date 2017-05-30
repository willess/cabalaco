<?php

//er wordt connectie gemaakt met de database
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'cabalco';

$db = mysqli_connect($host, $user, $password, $database) or die("error: " . mysqli_connect_error());

?>
