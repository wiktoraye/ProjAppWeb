<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = ''; // 
$baza = 'moja strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

if (!$link) {
    die('<b>Przerwane połączenie: </b>' . mysqli_connect_error());
}
?>
