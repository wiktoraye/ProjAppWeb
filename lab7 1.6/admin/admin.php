<?php
function FormularzLogowania() {
    echo '<form method="post" action="admin.php">
            <label for="login">Login:</label><br>
            <input type="text" id="login" name="login"><br>
            <label for="pass">Hasło:</label><br>
            <input type="password" id="pass" name="pass"><br><br>
            <input type="submit" value="Zaloguj">
          </form>';
}

session_start();
require_once 'cfg.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'], $_POST['pass'])) {
        if ($_POST['login'] === $login && $_POST['pass'] === $pass) {
            $_SESSION['loggedin'] = true;
        } else {
            echo '<p style="color:red;">Nieprawidłowy login lub hasło!</p>';
            FormularzLogowania();
            exit;
        }
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '<p>Musisz się zalogować, aby uzyskać dostęp do panelu administracyjnego.</p>';
    FormularzLogowania();
    exit;
}

function ListaPodstron() {
    global $link;

    // Zmiana zapytania, by pasowało do kolumn: page_title, page_content, status
    $query = "SELECT id, page_title FROM page_list ORDER BY id ASC";
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

function EdytujPodstrone() {
    global $link;

    if (isset($_POST['save'])) {
        $id = (int)$_POST['id'];
        $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
        $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
        $status = isset($_POST['status']) ? 1 : 0;

        // Zaktualizowanie zapytania
        $query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status=$status WHERE id=$id";
        if (mysqli_query($link, $query)) {
            echo "<p>Podstrona została zaktualizowana!</p>";
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

function DodajNowaPodstrone() {
    global $link;

    if (isset($_POST['add'])) {
        $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
        $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
        $status = isset($_POST['status']) ? 1 : 0;

        // Zaktualizowanie zapytania
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', $status)";
        if (mysqli_query($link, $query)) {
            echo "<p>Nowa podstrona została dodana!</p>";
        } else {
            echo "<p>Błąd podczas dodawania: " . mysqli_error($link) . "</p>";
        }
    }

    echo '<form method="post" action="admin.php?action=add">
            <label for="page_title">Tytuł:</label><br>
            <input type="text" id="page_title" name="page_title"><br>
            <label for="page_content">Treść:</label><br>
            <textarea id="page_content" name="page_content"></textarea><br>
            <label><input type="checkbox" name="status"> Aktywna</label><br><br>
            <input type="submit" name="add" value="Dodaj">
          </form>';
}

function UsunPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        // Zaktualizowanie zapytania
        $query = "DELETE FROM page_list WHERE id=$id";
        if (mysqli_query($link, $query)) {
            echo "<p>Podstrona została usunięta!</p>";
        } else {
            echo "<p>Błąd podczas usuwania: " . mysqli_error($link) . "</p>";
        }
    }
}

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
        default:
            ListaPodstron();
    }
} else {
    ListaPodstron();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>
<a href="admin.php?logout=true">Wyloguj</a>
