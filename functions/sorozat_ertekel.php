<?php

session_start();

if (!isset($_SESSION['felhasznalonev']) || !isset($_POST['sorozat_cim']) || !isset($_POST['ertekeles'])) {
    die("bajsz");
} //~debug

$sorozat_cim = $_POST['sorozat_cim'];
$ertekeles = (int)$_POST['ertekeles'];

//1 - 10
if ($ertekeles < 1 || $ertekeles > 10) {
    die("1 - 10"); //bed
}

//kapcs
$conn = mysqli_connect('localhost', 'root', '', 'imdb');
if (!$conn) {
    die("nem ji");//deb
}

//filem friss
$sql = "UPDATE sorozat SET ertekeles_darab = ertekeles_darab + 1, ertekeles_osszeg = ertekeles_osszeg + ? WHERE sorozat_cim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $ertekeles, $sorozat_cim);

if ($stmt->execute()) { //vehgrehajt
    echo "pacek"; //deb
} else {
    echo "hiba"; //deb
}

$stmt->close();
$conn->close();
header("Location: ../php/sorozatok.php");
exit();