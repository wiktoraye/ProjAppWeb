<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Ustal, którą stronę załadować na podstawie parametru 'idp'
if ($_GET['idp'] == '') $strona = 'html/glowna.html';
if ($_GET['idp'] == 'informacje') $strona = 'html/informacje.html';
if ($_GET['idp'] == 'galerie') $strona = 'html/galerie.html';
if ($_GET['idp'] == 'uslugi') $strona = 'html/uslugi.html';
if ($_GET['idp'] == 'kontakt') $strona = 'html/kontakt.html';
if ($_GET['idp'] == 'poligon') $strona = 'html/poligon.html';


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Projektowanie Ubran</title>
    <script src="../js/timedate.js" type="text/javascript"></script>
	<script src="../js/kolorujtlo.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="startclock()">

<video autoplay muted loop class="background-video">
    <source src="../galeria/aye3d2.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="container">

<?php include($strona); ?>

    <div id="zegarek"></div>
    <div id="data"></div>

    <footer>
        <p>&copy; 2024 AYE</p>
    </footer>
</div>

<?php
$nr_indeksu = '169247';
$nrGrupy = '2';
echo 'Autor: Wiktor Jakacki :'.$nr_indeksu.' grupa '.$nrGrupy.' <br/><br/>';
?>

</body>
</html>
