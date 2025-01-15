<?php
/**
 * Funkcja wyświetlająca formularz kontaktowy.
 * Zwraca kod HTML formularza.
 */
function PokazKontakt() {
    return '
        <h2>Formularz Kontaktowy</h2>
        <form method="POST" action="index.php?idp=contact">
            <label for="name">Imię:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Wiadomość:</label>
            <textarea id="message" name="message" required></textarea>
            
            <button type="submit">Wyślij</button>
        </form>
    ';
}

/**
 * Funkcja wysyłająca wiadomość e-mail z formularza kontaktowego.
 *
 * @param string $name Imię nadawcy.
 * @param string $email Adres e-mail nadawcy.
 * @param string $message Treść wiadomości.
 * @return string Informacja o powodzeniu lub błędzie podczas wysyłania wiadomości.
 */
function WyslijMailKontakt($name, $email, $message) {
    // Walidacja danych wejściowych
    $name = htmlspecialchars(trim($name));
    $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($message));

    if (!$email) {
        return "<p>Błąd: podano nieprawidłowy adres e-mail.</p>";
    }

    // Dane e-mail
    $to = "wiktorjakacki@gmail.com";
    $subject = "Nowa wiadomość z formularza kontaktowego";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8";
    $body = "Imię: $name\n";
    $body .= "E-mail: $email\n\n";
    $body .= "Wiadomość:\n$message";

    // Wysyłanie wiadomości
    if (mail($to, $subject, $body, $headers)) {
        return "<p>Wiadomość została wysłana pomyślnie. Dziękujemy za kontakt!</p>";
    } else {
        return "<p>Błąd: nie udało się wysłać wiadomości. Spróbuj ponownie później.</p>";
    }
}

/**
 * Funkcja wysyłająca przypomnienie hasła na adres e-mail.
 *
 * @param string $email Adres e-mail użytkownika.
 * @return string Informacja o powodzeniu lub błędzie podczas wysyłania hasła.
 */
function PrzypomnijHaslo($email) {
    // Walidacja adresu e-mail
    $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

    if (!$email) {
        return "<p>Błąd: podano nieprawidłowy adres e-mail.</p>";
    }

    // Dane e-mail
    $to = $email;
    $subject = "Przypomnienie hasła";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8";
    $body = "Twoje hasło do panelu admina to: [wpisz_haslo_tutaj]";

    // Wysyłanie wiadomości
    if (mail($to, $subject, $body, $headers)) {
        return "<p>Hasło zostało wysłane na podany e-mail.</p>";
    } else {
        return "<p>Błąd: nie udało się wysłać hasła. Spróbuj ponownie później.</p>";
    }
}
?>
