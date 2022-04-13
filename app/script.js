function calc() {
    var r = document.getElementById('promien').value;
    var a = (4 / 3);
    var pi = 3.14;
    var dzialanie = a * Math.PI * Math.pow(r, 3);
    document.getElementById('wynik').value = dzialanie;

}


