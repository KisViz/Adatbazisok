<?php
//a felh nevhez kell
session_start();

//be van e jelentkezve
if (!isset($_SESSION['felhasznalonev'])) {
    die("Kérjük, jelentkezzen be a film hozzáadásához.");
}

//adatb kapcsolat
$conn = mysqli_connect('localhost', 'root', '', 'imdb') or die("Hibás csatlakozás!");

//karakter kodolas
mysqli_set_charset($conn, 'utf8');

//urlaprol behuzzuk az adatokat ~lehetne a postossal de igy egyszerukk~
$szinesz_nev = mysqli_real_escape_string($conn, $_POST['szinesz_nev']);
$szuletesi_datum = mysqli_real_escape_string($conn, $_POST['szuletesi_datum']);
$allampolgarsag = mysqli_real_escape_string($conn, $_POST['allampolgarsag']);

//megnezzuk van e ilyen film mar
$proba = "SELECT * FROM szinesz WHERE szinesz_nev='$szinesz_nev' AND szuletesi_datum='$szuletesi_datum'";
$letezik = mysqli_query($conn, $proba);

if (mysqli_num_rows($letezik) > 0) {
    echo "mar van"; //igazabol nem tortenik semmi - debug
} else {
    //1 uj film beszurasa felh nev nelkul
    $ujszinesz = "INSERT INTO szinesz (szinesz_nev, szuletesi_datum, allampolgarsag) 
                          VALUES ('$szinesz_nev', '$szuletesi_datum', '$allampolgarsag')";

    mysqli_query($conn, $ujszinesz);
}

// kapcs zar
mysqli_close($conn);

//vissza
header("Location: ../php/szineszek.php");
exit();