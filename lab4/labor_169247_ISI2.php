<?php
$nr_indeksu = '169247';
$nrGrupy = 'ISI2';

echo 'Wiktor Jakacki, nr indeksu: '.$nr_indeksu.' grupa: '.$nrGrupy.'<br /><br/>';
echo 'Zastosowanie metody include() <br/>';

include('plik.php');

echo '<br/>Zastosowanie: Warunki if, else, elseif, switch  <br/>';
$liczba = 5;
echo 'Liczba = ' .$liczba. '<br/>';
if ($liczba < 10) {
    echo 'Liczba jest mniejsza niż 10 <br/>' ;
} else {
    echo 'Liczba jest większa lub równa 10 <br/>';
}

echo '<br/> Uzycie switcha: <br/>';
switch ($nrGrupy) {
    case 'ISI1':
        echo 'Grupa ISI1 <br/>';
        break;
    case 'ISI2':
        echo 'Grupa ISI2 <br/>';
        break;
    default:
        echo 'Inna grupa <br/>';
}
echo '<br/>Zastosowanie: While<br/>';
$i = 0;
while ($i < 5) {
    echo $i . ' ';
    $i++;
}

echo '<br/><br/>Zastosowanie: For<br/>';
for ($i = 0; $i < 5; $i++) {
    echo $i . '<br/>';
}

echo '<br/>Zastosowanie: Typy zmiennych $_GET, $_POST, $_SESSION<br/>';
session_start(); // Zaczynamy sesję
$_SESSION['user'] = 'Jan Kowalski';
echo 'Sesja użytkownika: '.$_SESSION['user'];

$_GET['id'] = 1; // Symulacja danych z URL
echo 'ID: '.$_GET['id'];

$_POST['name'] = 'Jan'; // Symulacja danych z formularza POST
echo 'Imię: '.$_POST['name'];
?>