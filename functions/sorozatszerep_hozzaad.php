<?php
//datab kapcs
$conn = mysqli_connect('localhost', 'root', '', 'imdb') or die("Hibás csatlakozás!");

//kk
mysqli_set_charset($conn, 'utf8');

//besued
$valasztott_szinesz = $_POST['valasztott_szinesz'];
$valasztott_sorozat = $_POST['valasztott_sorozat'];
$soriszerep = $_POST['soriszerep'];

//szeteszedi az osszefuzest
list($szinesz_nev, $szuletesi_datum) = explode('|', $valasztott_szinesz);

//ebteszi a sor szerepbe
$insert_query = "INSERT INTO sorozatban_szerepel (sorozat_cim, szinesz_nev, szuletesi_datum, sorozatszerep) VALUES ('$valasztott_sorozat', '$szinesz_nev', '$szuletesi_datum', '$soriszerep')";

try { //ha mar va ne tortenjen semmi
    mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
} catch (exception $e) {}

//zar
mysqli_close($conn);

header("Location: ../php/szineszek.php"); //vissza
exit();

