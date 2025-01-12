<?php
session_start();

//felh be vane jelentkezva
if (!isset($_SESSION['felhasznalonev'])) {
    die("Be kell jelentkezned a művelethez.");
}

//kapcs
$conn = mysqli_connect('localhost', 'root', '', 'imdb');
if (!$conn) {
    die("Hibás csatlakozás az adatbázishoz.");
}

//karkod
mysqli_set_charset($conn, 'utf8');

//adatok osszeszedese
$sorozat_cim = $_POST['sorozat_cim'];
$resz_evad = $_POST['evad'];
$resz_cim = $_POST['resz_cim'];
$felhasznalonev = $_SESSION['felhasznalonev'];

//beszuras
$sql = "INSERT INTO resz (resz_cim, resz_evad, sorozat_cim, felhasznalonev ) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) { //ha nem falsot adott vissza
    mysqli_stmt_bind_param($stmt, "siss", $resz_cim, $resz_evad, $sorozat_cim, $felhasznalonev);//bele teszuk az adatokat
    mysqli_stmt_execute($stmt); //vegrahajtjuk

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<p>siker</p>"; //~debug
    } else {
        echo "<p>bajsz</p>"; //~debug
    }

    mysqli_stmt_close($stmt); //erofroo felszab
} else {
    echo "<p>hiba</p>"; //~debug
}

mysqli_close($conn);
header("Location: ../php/sorozatok.php");
exit();