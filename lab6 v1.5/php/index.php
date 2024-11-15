<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


include('cfg.php');
include('showpage.php');


$idp = $_GET['idp'] ?? 'glowna';


$page_id = 1; 

switch ($idp) {
    case 'projekty':
        $page_id = 2;
        break;
    case 'materialy':
        $page_id = 3;
        break;
    case 'porady':
        $page_id = 4;
        break;
    case 'inspiracje':
        $page_id = 5;
        break;
    case 'kontakt':
        $page_id = 6;
        break;
}


$strona_content = PokazPodstrone($page_id);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Damian Todorowski" />
    <title>Moje Hobby: Projektowanie Ubrań</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css"> 
    <script src="../js/script.js" type="text/javascript"></script> 
    <script src="../js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startClock()">
    <div id="wrapper"> 
        <header>
            <video autoplay muted loop>
                <source src="../video/aye3d2.mp4" type="video/mp4">
                Twój przeglądarka nie obsługuje elementu video.
            </video>
        </header>
        <nav>
            <a class="menu" href="index.php?idp=glowna">Strona głowna</a>
            <a class="menu" href="index.php?idp=projekty">Moje projekty</a>
            <a class="menu" href="index.php?idp=materialy">Wybór materiałów</a>
            <a class="menu" href="index.php?idp=porady">Porady projektanta</a>
            <a class="menu" href="index.php?idp=inspiracje">Inspiracje</a>
            <a class="menu" href="index.php?idp=kontakt">Kontakt</a>
        </nav>
        <section>
            <!-- Wyświetlanie treści strony z bazy danych -->
            <?php echo $strona_content; ?>
        </section>
		
		<h2>Zmiana koloru tła</h2>
                <button onclick="changeBackground('#D3D3D3')">Zmień tło na szare</button>
                <button onclick="changeBackground('#FFD700')">Zmień tło na złote</button>
				
		<div id="zegarek"></div>
        <div id="data"></div>
		
        <footer>
            <?php
            $nr_indeksu = '169247';
            $nrGrupy = '2';
            echo 'Autor: Wiktor Jakacki   ' . $nr_indeksu . '   grupa: ' . $nrGrupy . '<br /><br />'; 
            ?>
        </footer>
		
    </div>
	
	
    <script>
    $(document).ready(function() {
        $("a.menu").on({
            mouseover: function() {
                $(this).animate({ width: 300 }, 800);
            },
            mouseout: function() {
                $(this).animate({ width: 200 }, 800);
            }
        });

        $("#animacjaTestowa1").on("click", function() {
            $(this).animate({ width: "500px", opacity: 0.4, fontSize: "3em", borderWidth: "10px" }, 1500);
        });

        $("#mataleoImage").on("click", function() {
            if (!$(this).is(":animated")) {
                $(this).animate({ width: "+=50", height: "+=10", opacity: "+=0.1" }, 1000);
            }
        });
    });
    </script>
</body>
</html>
