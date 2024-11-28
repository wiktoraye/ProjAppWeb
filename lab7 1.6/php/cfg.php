<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = ''; 
$baza = 'moja_strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

if (!$link) {
    die('<b>Przerwane połączenie: </b>' . mysqli_connect_error());
}

$login = 'admin'; // Przykładowa nazwa użytkownika
$pass = '1234';   // Przykładowe hasło (należy je zaszyfrować w produkcji!)

?>
