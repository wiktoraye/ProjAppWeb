<?php
session_start();

// Inicjalizacja koszyka jeśli nie istnieje
if (!isset($_SESSION['koszyk'])) {
    $_SESSION['koszyk'] = array();
}

// Obsługa dodawania produktu do koszyka
if (isset($_POST['dodaj_do_koszyka'])) {
    $produkt = array(
        'id' => $_POST['id'],
        'tytul' => $_POST['tytul'],
        'cena' => $_POST['cena'],
        'ilosc' => $_POST['ilosc']
    );
    
    // Sprawdzenie czy produkt już jest w koszyku
    $znaleziono = false;
    foreach ($_SESSION['koszyk'] as &$item) {
        if ($item['id'] == $produkt['id']) {
            $item['ilosc'] += $produkt['ilosc'];
            $znaleziono = true;
            break;
        }
    }
    
    if (!$znaleziono) {
        array_push($_SESSION['koszyk'], $produkt);
    }
}

// Obsługa usuwania produktu z koszyka
if (isset($_POST['usun_z_koszyka'])) {
    $id_do_usuniecia = $_POST['id'];
    foreach ($_SESSION['koszyk'] as $key => $item) {
        if ($item['id'] == $id_do_usuniecia) {
            unset($_SESSION['koszyk'][$key]);
            break;
        }
    }
    $_SESSION['koszyk'] = array_values($_SESSION['koszyk']);
}

// Wyświetlanie zawartości koszyka
echo '<h1>Koszyk</h1>';

if (empty($_SESSION['koszyk'])) {
    echo '<p class="empty-cart">Twój koszyk jest pusty.</p>';
} else {
    echo '<div class="koszyk-container">';
    echo '<table class="koszyk-table">';
    echo '<tr>
            <th>Produkt</th>
            <th>Ilość</th>
            <th>Cena jednostkowa</th>
            <th>Suma</th>
            <th>Akcje</th>
          </tr>';
    
    $suma_calkowita = 0;
    
    foreach ($_SESSION['koszyk'] as $produkt) {
        $suma = $produkt['cena'] * $produkt['ilosc'];
        $suma_calkowita += $suma;
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($produkt['tytul']) . '</td>';
        echo '<td>' . $produkt['ilosc'] . '</td>';
        echo '<td>' . number_format($produkt['cena'], 2) . ' PLN</td>';
        echo '<td>' . number_format($suma, 2) . ' PLN</td>';
        echo '<td>';
        echo '<form method="post" action="index.php?idp=cart">';
        echo '<input type="hidden" name="id" value="' . $produkt['id'] . '">';
        echo '<button type="submit" name="usun_z_koszyka" class="remove-btn">Usuń</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '<tr class="total-row">';
    echo '<td colspan="3" class="text-right"><strong>Suma całkowita:</strong></td>';
    echo '<td><strong>' . number_format($suma_calkowita, 2) . ' PLN</strong></td>';
    echo '<td></td>';
    echo '</tr>';
    echo '</table>';
    
    echo '<div class="checkout-section">';
    echo '<form method="post" action="index.php?idp=zamowienie">';
    echo '<button type="submit" name="zloz_zamowienie" class="zloz-zamowienie-btn">Złóż zamówienie</button>';
    echo '</form>';
    echo '</div>';
    
    echo '</div>';
}
?>