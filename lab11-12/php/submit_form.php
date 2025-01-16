<?php
// -------------------------------
// Formularz kontaktowy - Obsługa wysyłki wiadomości e-mail
// -------------------------------

// Sprawdzamy, czy formularz został wysłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // -------------------------------
    // Pobranie i wstępne przetwarzanie danych wejściowych
    // -------------------------------

    // Pobranie danych z formularza z podstawowym filtrowaniem i walidacją
    $name = htmlspecialchars(trim($_POST['name'])); // Usunięcie nadmiarowych spacji i zabezpieczenie przed HTML
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL); // Walidacja adresu e-mail
    $message = htmlspecialchars(trim($_POST['message'])); // Usunięcie nadmiarowych spacji i zabezpieczenie przed HTML

    // -------------------------------
    // Walidacja danych wejściowych
    // -------------------------------

    // Sprawdzenie, czy wszystkie wymagane pola zostały wypełnione
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color: red; text-align: center;">Wszystkie pola są wymagane!</p>';
        exit; // Zatrzymanie dalszego przetwarzania
    }

    // Sprawdzenie poprawności adresu e-mail
    if (!$email) {
        echo '<p style="color: red; text-align: center;">Podano nieprawidłowy adres e-mail!</p>';
        exit; // Zatrzymanie dalszego przetwarzania
    }

    // -------------------------------
    // Przygotowanie wiadomości e-mail
    // -------------------------------

    // Adres odbiorcy - dostosuj do swoich potrzeb
    $recipient = 'wiktorjakacki@gmail.com';

    // Temat wiadomości
    $subject = "Nowa wiadomość od $name";

    // Treść wiadomości
    $emailContent = "Imię i nazwisko: $name\n";
    $emailContent .= "E-mail: $email\n\n";
    $emailContent .= "Wiadomość:\n$message\n";

    // Nagłówki wiadomości e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // -------------------------------
    // Wysłanie wiadomości e-mail
    // -------------------------------

    // Funkcja mail() do wysyłki wiadomości
    if (mail($recipient, $subject, $emailContent, $headers)) {
        echo '<p style="color: green; text-align: center;">Wiadomość została wysłana pomyślnie!</p>';
    } else {
        echo '<p style="color: red; text-align: center;">Wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.</p>';
    }
} else {
    // Obsługa nieprawidłowego żądania (np. GET zamiast POST)
    echo '<p style="color: red; text-align: center;">Nieprawidłowe żądanie!</p>';
}
?>
