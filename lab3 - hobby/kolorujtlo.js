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
    const video = document.querySelector('.background-video');
    video.style.display = 'none';
    document.body.style.backgroundImage = 'none';
    document.body.style.backgroundColor = color;
}

function resetBackground() {
    const video = document.querySelector('.background-video');
    video.style.display = 'block';
    document.body.style.backgroundColor = 'transparent';
    document.body.style.backgroundImage = 'none';
}

function changeBackgroundToImage(imagePath) {
    const video = document.querySelector('.background-video');
    video.style.display = 'none';
    document.body.style.backgroundColor = 'transparent';
    document.body.style.backgroundImage = `url(${imagePath})`;
    document.body.style.backgroundSize = 'cover';
    document.body.style.backgroundPosition = 'center';
}
