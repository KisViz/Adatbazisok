<?php

session_start();

//ha valami nincs beallitva
if (!isset($_SESSION['felhasznalonev']) || !isset($_POST['film_cim']) || !isset($_POST['ertekeles']) ||!isset($_POST['megjelenes_eve'])) {
    die("bajsz");
} //~debug

$film_cim = $_POST['film_cim'];
$megjelenes_eve = $_POST['megjelenes_eve'];
$ertekeles = (int)$_POST['ertekeles'];

//1 - 10
if ($ertekeles < 1 || $ertekeles > 10) {
    die("1 - 10"); //bed
}

//kapcs
$conn = mysqli_connect('localhost', 'root', '', 'imdb');
if (!$conn) {
    die("Hiba a csatlakozásnál!");
}

//filem friss
$sql = "UPDATE film SET ertekeles_darab = ertekeles_darab + 1, ertekeles_osszeg = ertekeles_osszeg + ? WHERE film_cim = ? and megjelenes_eve = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $ertekeles, $film_cim, $megjelenes_eve);
                       //international space station

if ($stmt->execute()) { //vehgrehajt
    echo "pacek"; //deb
} else {
    echo "hiba"; //deb
}

$stmt->close(); //lezarja az utasitast
$conn->close(); //ez meg a kapcsolatot
header("Location: ../php/filmek.php");
exit();

