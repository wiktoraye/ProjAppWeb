<?php
require_once 'cfg.php';

function PokazProdukty() {
    global $link;
    
    echo '<h1>Dostępne produkty</h1>';
    echo '<div class="produkty-container">';
    
    $query = "SELECT * FROM produkty WHERE status_dostepnosci = 'dostepny'";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die("Błąd w zapytaniu: " . mysqli_error($link));
    }
    
    while ($produkt = mysqli_fetch_assoc($result)) {
        echo '<div class="produkt-card">';
        
        if (!empty($produkt['zdjecie'])) {
    echo '<img src="data:image/jpeg;base64,' . base64_encode($produkt['zdjecie']) . '" alt="Zdjęcie produktu" class="produkt-image">';
}
        
        echo '<h3>' . htmlspecialchars($produkt['tytul']) . '</h3>';
        echo '<p><strong>ID:</strong> ' . htmlspecialchars($produkt['id']) . '</p>';
        echo '<p><strong>Cena netto:</strong> ' . number_format($produkt['cena_netto'], 2) . ' PLN</p>';
        echo '<p><strong>VAT:</strong> ' . number_format($produkt['podatek_vat'], 2) . ' PLN</p>';
        echo '<p><strong>Cena brutto:</strong> ' . number_format($produkt['cena_netto'] + $produkt['podatek_vat'], 2) . ' PLN</p>';
        echo '<p><strong>Dostępna ilość:</strong> ' . $produkt['ilosc_dostepnych'] . '</p>';
        echo '<p><strong>Rozmiar:</strong> ' . htmlspecialchars($produkt['gabaryt']) . '</p>';
        
        if ($produkt['ilosc_dostepnych'] > 0) {
            echo '<form method="post" action="index.php?idp=cart">';
            echo '<input type="hidden" name="id" value="' . $produkt['id'] . '">';
            echo '<input type="hidden" name="tytul" value="' . htmlspecialchars($produkt['tytul']) . '">';
            echo '<input type="hidden" name="cena" value="' . ($produkt['cena_netto'] + $produkt['podatek_vat']) . '">';
            echo '<div class="form-group">';
            echo '<label>Ilość: </label>';
            echo '<input type="number" name="ilosc" value="1" min="1" max="' . $produkt['ilosc_dostepnych'] . '" required class="quantity-input">';
            echo '<button type="submit" name="dodaj_do_koszyka" class="add-to-cart-btn">Dodaj do koszyka</button>';
            echo '</div>';
            echo '</form>';
        } else {
            echo '<p class="unavailable">Produkt niedostępny</p>';
        }
        
        echo '</div>';
    }
    
    echo '</div>';
}

// Wywołanie funkcji wyświetlającej produkty
PokazProdukty();
?>