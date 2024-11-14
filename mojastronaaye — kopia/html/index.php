<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Projektowanie Ubran</title>
	<script src="../js/timedate.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="startclock()">

<video autoplay muted loop class="background-video">
    <source src="../galeria/aye3d2.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="container">
    <header>
        <h1>Moje Hobby: Projektowanie ubran</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.html" class="active">Strona Główna</a></li>
            <li><a href="informacje.html">Informacje</a></li>
            <li><a href="galerie.html">Galerie</a></li>
            <li><a href="uslugi.html">Usługi</a></li>
            <li><a href="kontakt.html">Kontakt</a></li>
			<li><a href="poligon.html">Poligon</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <h2>Witamy!</h2>
        <p>Projektowanie ubrań to moja pasja. Poniżej znajdziesz mój ostatni projekt:</p>
        <div class="gallery-item">
            <img src="../galeria/projekt1.png" alt="Projekt 1">
        </div>
		
    </main>

<div id="zegarek"></div>
<div id="data"></div>

    <footer>
        <p>&copy; 2024 AYE</p>
    </footer>
</div>

<?php
$nr_indeksu = '1234567';
$nrGrupy = 'X';

echo 'Autor: Jan Kowalski :'.$nr_indeksu.' grupa '.$nrGrupy.' <br/><br/>';
?>



</body>
</html>
