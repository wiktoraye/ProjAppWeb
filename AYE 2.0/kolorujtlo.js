var computed = false;
var decimal = 0;

function convert(entryform, from, to) {
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

function addChar(input, character) {
    if ((character == '.' && decimal == "0") || character != '.') {
        if (input.value == "" || input.value == "0") {
            input.value = character;
        } else {
            input.value += character;
        }
        convert(input.form, input.form.measure1, input.form.measure2);
        computed = true;
        if (character == '.') {
            decimal = 1;
        }
    }
}

function openVotchcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

function clear(form) {
    form.input.value = 0;
    form.display.value = 0;
    decimal = 0;
}

function changeBackground(color) {
    // Ukrywamy wideo i zmieniamy kolor tła
    const video = document.querySelector('.background-video');
    video.style.display = 'none'; // Ukryj wideo
    document.body.style.backgroundImage = 'none'; // Usuwamy ewentualne tło obrazkowe
    document.body.style.backgroundColor = color; // Zmieniamy kolor tła
}

function resetBackground() {
    // Przywrócenie wideo i usunięcie koloru tła
    const video = document.querySelector('.background-video');
    video.style.display = 'block'; // Pokazujemy z powrotem wideo
    document.body.style.backgroundColor = 'transparent'; // Usuwamy kolor tła
    document.body.style.backgroundImage = 'none'; // Usuwamy ewentualne tło obrazkowe
}

function changeBackgroundToImage(imagePath) {
    // Ukrywamy wideo i ustawiamy obrazek jako tło
    const video = document.querySelector('.background-video');
    video.style.display = 'none'; // Ukryj wideo
    document.body.style.backgroundColor = 'transparent'; // Usuwamy ewentualny kolor tła
    document.body.style.backgroundImage = `url(${imagePath})`; // Ustawiamy obraz jako tło
    document.body.style.backgroundSize = 'cover'; // Dopasowujemy rozmiar obrazu
    document.body.style.backgroundPosition = 'center'; // Obraz na środku
}
