<?php
// Sprawdzamy, czy formularz został wysłany
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobranie danych z formularza
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Walidacja danych
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color: red; text-align: center;">Wszystkie pola są wymagane!</p>';
        exit;
    }

    if (!$email) {
        echo '<p style="color: red; text-align: center;">Podano nieprawidłowy adres e-mail!</p>';
        exit;
    }

    // Adres odbiorcy
    $recipient = 'wiktorjakacki@gmail.com'; // Zmień na swój adres e-mail

    // Temat wiadomości
    $subject = "Nowa wiadomość od $name";

    // Treść wiadomości
    $emailContent = "Imię i nazwisko: $name\n";
    $emailContent .= "E-mail: $email\n\n";
    $emailContent .= "Wiadomość:\n$message\n";

    // Nagłówki
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Wysłanie wiadomości
    if (mail($recipient, $subject, $emailContent, $headers)) {
        echo '<p style="color: green; text-align: center;">Wiadomość została wysłana pomyślnie!</p>';
    } else {
        echo '<p style="color: red; text-align: center;">Wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.</p>';
    }
} else {
    echo '<p style="color: red; text-align: center;">Nieprawidłowe żądanie!</p>';
}
?>
