<?php
//kapcsolatt
$conn = mysqli_connect('localhost', 'root', '', 'imdb') or die("Hibás csatlakozás!");

//karkodolss
mysqli_set_charset($conn, 'utf8');

//urlaprol ba
$valasztott_szinesz = $_POST['valasztott_szinesz'];
$valasztott_film = $_POST['valasztott_film'];
$filmszerep = $_POST['filmszerep'];

//szetszedi az osszefuzott adatoat
list($szinesz_nev, $szuletesi_datum) = explode('|', $valasztott_szinesz);
list($film_cim, $megjelenesi_datum) = explode('|', $valasztott_film);

//filben szereele be beszur
$insert_query = "INSERT INTO filmben_szerepel (film_cim, megjelenes_eve, szinesz_nev, szuletesi_datum, filmszerep) VALUES ('$film_cim', '$megjelenesi_datum', '$szinesz_nev', '$szuletesi_datum', '$filmszerep')";

try { //ha mar van ne tortenjen semmi
    mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
} catch (Exception $ex) {}

//kapcs zar
mysqli_close($conn);

header("Location: ../php/szineszek.php"); //vissza
exit();

