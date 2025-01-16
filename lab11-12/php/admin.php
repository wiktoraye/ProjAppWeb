<?php
/**
 * Funkcja do wyświetlania formularza logowania
 */
function FormularzLogowania() {
    echo '<form method="post" action="admin.php">
            <label for="login">Login:</label><br>
            <input type="text" id="login" name="login" required><br>
            <label for="pass">Hasło:</label><br>
            <input type="password" id="pass" name="pass" required><br><br>
            <input type="submit" value="Zaloguj">
          </form>';
}

// Rozpoczęcie sesji
session_start();
require_once 'cfg.php';

/**
 * Obsługa logowania
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'], $_POST['pass'])) {
        $userLogin = htmlspecialchars($_POST['login']);
        $userPass = htmlspecialchars($_POST['pass']);

        if ($userLogin === $login && $userPass === $pass) {
            $_SESSION['loggedin'] = true;
        } else {
            echo '<p style="color:red;">Nieprawidłowy login lub hasło!</p>';
            FormularzLogowania();
            exit;
        }
    }
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '<p>Musisz się zalogować, aby uzyskać dostęp do panelu administracyjnego.</p>';
    FormularzLogowania();
    exit;
}

/**
 * Wyświetlanie listy podstron
 */
function ListaPodstron() {
    global $link;

    $query = "SELECT id, page_title FROM page_list ORDER BY id ASC LIMIT 100";
    $result = mysqli_query($link, $query);

    echo '<h2>Lista podstron</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['page_title']) . '</td>';
        echo '<td>
                <a href="admin.php?action=edit&id=' . $row['id'] . '">Edytuj</a> |
                <a href="admin.php?action=delete&id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć?\')">Usuń</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<a href="admin.php?action=add">Dodaj nową podstronę</a>';
}

/**
 * Funkcja do edytowania podstrony
 */
function EdytujPodstrone() {
    global $link;

    if (isset($_POST['save'])) {
        $id = (int)$_POST['id'];
        $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
        $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status=$status WHERE id=$id";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas aktualizacji: " . mysqli_error($link) . "</p>";
        }
    }

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM page_list WHERE id=$id";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        echo '<form method="post" action="admin.php?action=edit">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <label for="page_title">Tytuł:</label><br>
                <input type="text" id="page_title" name="page_title" value="' . htmlspecialchars($row['page_title']) . '"><br>
                <label for="page_content">Treść:</label><br>
                <textarea id="page_content" name="page_content">' . htmlspecialchars($row['page_content']) . '</textarea><br>
                <label><input type="checkbox" name="status" ' . ($row['status'] ? 'checked' : '') . '> Aktywna</label><br><br>
                <input type="submit" name="save" value="Zapisz">
              </form>';
    }
}

/**
 * Funkcja do dodawania nowej podstrony
 */
function DodajNowaPodstrone() {
    global $link;

    if (isset($_POST['add'])) {
        $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
        $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', $status)";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas dodawania: " . mysqli_error($link) . "</p>";
        }
    }

    echo '<form method="post" action="admin.php?action=add">
            <label for="page_title">Tytuł:</label><br>
            <input type="text" id="page_title" name="page_title" required><br>
            <label for="page_content">Treść:</label><br>
            <textarea id="page_content" name="page_content" required></textarea><br>
            <label><input type="checkbox" name="status"> Aktywna</label><br><br>
            <input type="submit" name="add" value="Dodaj">
          </form>';
}

/**
 * Funkcja do usuwania podstrony
 */
function UsunPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "DELETE FROM page_list WHERE id=$id";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas usuwania: " . mysqli_error($link) . "</p>";
        }
    }
}

/**
 * Funkcje zarządzania kategoriami
 */
function PokazKategorie() {
    global $link;

    $query = "SELECT * FROM kategorie ORDER BY id ASC";
    $result = mysqli_query($link, $query);

    echo '<h2>Lista kategorii</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Nazwa</th><th>ID Matki</th><th>Akcje</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['nazwa']) . '</td>';
        echo '<td>' . htmlspecialchars($row['matka']) . '</td>';
        echo '<td>
                <a href="admin.php?action=edit_category&id=' . $row['id'] . '">Edytuj</a> |
                <a href="admin.php?action=delete_category&id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę kategorię?\')">Usuń</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<a href="admin.php?action=add_category">Dodaj nową kategorię</a>';
}

function DodajKategorie() {
    global $link;

    if (isset($_POST['add_category'])) {
        $nazwa = mysqli_real_escape_string($link, $_POST['nazwa']);
        $matka = (int)$_POST['matka'];

        $query = "INSERT INTO kategorie (nazwa, matka) VALUES ('$nazwa', $matka)";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas dodawania: " . mysqli_error($link) . "</p>";
        }
    }

    $query = "SELECT id, nazwa FROM kategorie";
    $result = mysqli_query($link, $query);

    echo '<form method="post" action="admin.php?action=add_category">
            <label for="nazwa">Nazwa kategorii:</label><br>
            <input type="text" id="nazwa" name="nazwa" required><br>
            <label for="matka">Kategoria nadrzędna:</label><br>
            <select id="matka" name="matka">
                <option value="0">Brak</option>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
    }

    echo '  </select><br><br>
            <input type="submit" name="add_category" value="Dodaj">
          </form>';
}

function EdytujKategorie() {
    global $link;

    if (isset($_POST['save_category'])) {
        $id = (int)$_POST['id'];
        $nazwa = mysqli_real_escape_string($link, $_POST['nazwa']);
        $matka = (int)$_POST['matka'];

        $query = "UPDATE kategorie SET nazwa='$nazwa', matka=$matka WHERE id=$id";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas aktualizacji: " . mysqli_error($link) . "</p>";
        }
    }

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM kategorie WHERE id=$id";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        $query_kategorie = "SELECT id, nazwa FROM kategorie";
        $result_kategorie = mysqli_query($link, $query_kategorie);

        echo '<form method="post" action="admin.php?action=edit_category">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <label for="nazwa">Nazwa kategorii:</label><br>
                <input type="text" id="nazwa" name="nazwa" value="' . htmlspecialchars($row['nazwa']) . '" required><br>
                <label for="matka">Kategoria nadrzędna:</label><br>
                <select id="matka" name="matka">
                    <option value="0">Brak</option>';

        while ($kat = mysqli_fetch_assoc($result_kategorie)) {
            if ($kat['id'] != $row['id']) {
                $selected = ($kat['id'] == $row['matka']) ? 'selected' : '';
                echo '<option value="' . $kat['id'] . '" ' . $selected . '>' . htmlspecialchars($kat['nazwa']) . '</option>';
            }
        }

        echo '  </select><br><br>
                <input type="submit" name="save_category" value="Zapisz">
              </form>';
    }
}

function UsunKategorie() {
    global $link;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "DELETE FROM kategorie WHERE id=$id";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas usuwania: " . mysqli_error($link) . "</p>";
        }
    }
}



/**
 * Funkcja do dodawania nowego produktu
 */
function DodajProdukt() {
    global $link;

    if (isset($_POST['add_product'])) {
        $tytul = mysqli_real_escape_string($link, $_POST['tytul']);
        $opis = mysqli_real_escape_string($link, $_POST['opis']);
        $data_wygasniecia = $_POST['data_wygasniecia'] ?: NULL;
        $cena_netto = (float)$_POST['cena_netto'];
        $podatek_vat = (float)$_POST['podatek_vat'];
        $ilosc_dostepnych = (int)$_POST['ilosc_dostepnych'];
        $status_dostepnosci = mysqli_real_escape_string($link, $_POST['status_dostepnosci']);
        $gabaryt = mysqli_real_escape_string($link, $_POST['gabaryt']);
        $zdjecie = isset($_FILES['zdjecie']['tmp_name']) ? addslashes(file_get_contents($_FILES['zdjecie']['tmp_name'])) : NULL;

        $query = "INSERT INTO produkty (tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc_dostepnych, status_dostepnosci, gabaryt, zdjecie) 
                  VALUES ('$tytul', '$opis', '$data_wygasniecia', $cena_netto, $podatek_vat, $ilosc_dostepnych, '$status_dostepnosci', '$gabaryt', '$zdjecie')";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas dodawania produktu: " . mysqli_error($link) . "</p>";
        }
    }

    echo '<form method="post" action="admin.php?action=add_product" enctype="multipart/form-data">
            <label for="tytul">Tytuł:</label><br>
            <input type="text" id="tytul" name="tytul" required><br>
            <label for="opis">Opis:</label><br>
            <textarea id="opis" name="opis"></textarea><br>
            <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
            <input type="date" id="data_wygasniecia" name="data_wygasniecia"><br>
            <label for="cena_netto">Cena netto:</label><br>
            <input type="number" step="0.01" id="cena_netto" name="cena_netto" required><br>
            <label for="podatek_vat">Podatek VAT:</label><br>
            <input type="number" step="0.01" id="podatek_vat" name="podatek_vat" required><br>
            <label for="ilosc_dostepnych">Ilość dostępnych:</label><br>
            <input type="number" id="ilosc_dostepnych" name="ilosc_dostepnych" required><br>
            <label for="status_dostepnosci">Status dostępności:</label><br>
            <select id="status_dostepnosci" name="status_dostepnosci" required>
                <option value="dostępny">Dostępny</option>
                <option value="niedostępny">Niedostępny</option>
            </select><br>
            <label for="gabaryt">Gabaryt:</label><br>
            <input type="text" id="gabaryt" name="gabaryt"><br>
            <label for="zdjecie">Zdjęcie:</label><br>
            <input type="file" id="zdjecie" name="zdjecie"><br><br>
            <input type="submit" name="add_product" value="Dodaj Produkt">
          </form>';
}

/**
 * Funkcja do usuwania produktu
 */
function UsunProdukt() {
    global $link;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "DELETE FROM produkty WHERE id=$id";
        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas usuwania produktu: " . mysqli_error($link) . "</p>";
        }
    }
}

/**
 * Funkcja do edytowania produktu
 */
function EdytujProdukt() {
    global $link;

    if (isset($_POST['save_product'])) {
        $id = (int)$_POST['id'];
        $tytul = mysqli_real_escape_string($link, $_POST['tytul']);
        $opis = mysqli_real_escape_string($link, $_POST['opis']);
        $data_wygasniecia = $_POST['data_wygasniecia'] ?: NULL;
        $cena_netto = (float)$_POST['cena_netto'];
        $podatek_vat = (float)$_POST['podatek_vat'];
        $ilosc_dostepnych = (int)$_POST['ilosc_dostepnych'];
        $status_dostepnosci = mysqli_real_escape_string($link, $_POST['status_dostepnosci']);
        $gabaryt = mysqli_real_escape_string($link, $_POST['gabaryt']);

        // Sprawdzamy, czy został przesłany nowy plik i czy nie ma błędów
        $zdjecie_query = "";
        if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK && !empty($_FILES['zdjecie']['tmp_name'])) {
            $zdjecie = addslashes(file_get_contents($_FILES['zdjecie']['tmp_name']));
            $zdjecie_query = ", zdjecie='$zdjecie'";
        }

        $query = "UPDATE produkty SET 
                  tytul='$tytul', 
                  opis='$opis', 
                  data_wygasniecia=" . ($data_wygasniecia ? "'$data_wygasniecia'" : "NULL") . ", 
                  cena_netto=$cena_netto, 
                  podatek_vat=$podatek_vat, 
                  ilosc_dostepnych=$ilosc_dostepnych, 
                  status_dostepnosci='$status_dostepnosci', 
                  gabaryt='$gabaryt'
                  $zdjecie_query 
                  WHERE id=$id";

        if (mysqli_query($link, $query)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "<p>Błąd podczas aktualizacji produktu: " . mysqli_error($link) . "</p>";
        }
    }

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM produkty WHERE id=$id";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        echo '<form method="post" action="admin.php?action=edit_product" enctype="multipart/form-data">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <label for="tytul">Tytuł:</label><br>
                <input type="text" id="tytul" name="tytul" value="' . htmlspecialchars($row['tytul']) . '" required><br>
                <label for="opis">Opis:</label><br>
                <textarea id="opis" name="opis">' . htmlspecialchars($row['opis']) . '</textarea><br>
                <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
                <input type="date" id="data_wygasniecia" name="data_wygasniecia" value="' . htmlspecialchars($row['data_wygasniecia']) . '"><br>
                <label for="cena_netto">Cena netto:</label><br>
                <input type="number" step="0.01" id="cena_netto" name="cena_netto" value="' . htmlspecialchars($row['cena_netto']) . '" required><br>
                <label for="podatek_vat">Podatek VAT:</label><br>
                <input type="number" step="0.01" id="podatek_vat" name="podatek_vat" value="' . htmlspecialchars($row['podatek_vat']) . '" required><br>
                <label for="ilosc_dostepnych">Ilość dostępnych:</label><br>
                <input type="number" id="ilosc_dostepnych" name="ilosc_dostepnych" value="' . htmlspecialchars($row['ilosc_dostepnych']) . '" required><br>
                <label for="status_dostepnosci">Status dostępności:</label><br>
                <select id="status_dostepnosci" name="status_dostepnosci">
                    <option value="dostępny" ' . ($row['status_dostepnosci'] === 'dostępny' ? 'selected' : '') . '>Dostępny</option>
                    <option value="niedostępny" ' . ($row['status_dostepnosci'] === 'niedostępny' ? 'selected' : '') . '>Niedostępny</option>
                </select><br>
                <label for="gabaryt">Gabaryt:</label><br>
                <input type="text" id="gabaryt" name="gabaryt" value="' . htmlspecialchars($row['gabaryt']) . '"><br>
                <label for="zdjecie">Zdjęcie (pozostaw puste, aby nie zmieniać):</label><br>
                <input type="file" id="zdjecie" name="zdjecie"><br><br>
                <input type="submit" name="save_product" value="Zapisz">
              </form>';
    }
}

/**
 * Funkcja do wyświetlania listy produktów
 */
function PokazProdukty() {
    global $link;

    $query = "SELECT * FROM produkty ORDER BY id ASC";
    $result = mysqli_query($link, $query);

    echo '<h2>Lista produktów</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Cena netto</th><th>Status</th><th>Akcje</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['tytul']) . '</td>';
        echo '<td>' . htmlspecialchars($row['cena_netto']) . '</td>';
        echo '<td>' . htmlspecialchars($row['status_dostepnosci']) . '</td>';
        echo '<td>
                <a href="admin.php?action=edit_product&id=' . $row['id'] . '">Edytuj</a> |
                <a href="admin.php?action=delete_product&id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć ten produkt?\')">Usuń</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<a href="admin.php?action=add_product">Dodaj nowy produkt</a>';
}

/**
 * Obsługa akcji w panelu
 */
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'edit':
            EdytujPodstrone();
            break;
        case 'add':
            DodajNowaPodstrone();
            break;
        case 'delete':
            UsunPodstrone();
            break;
        case 'edit_category':
            EdytujKategorie();
            break;
        case 'add_category':
            DodajKategorie();
            break;
        case 'delete_category':
            UsunKategorie();
            break;
		case 'add_product':
			DodajProdukt();
			break;
		case 'edit_product':
			EdytujProdukt();
			break;
		case 'delete_product':
			UsunProdukt();
			break;
        default:
            ListaPodstron();
            PokazKategorie();
			PokazProdukty();
    }
} else {
    ListaPodstron();
    PokazKategorie();
	PokazProdukty();
}

/**
 * Wylogowanie użytkownika
 */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <a href="admin.php?logout=true" class="logout">Wyloguj</a>
</body>
</html>