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
$sorozat_cim = mysqli_real_escape_string($conn, $_POST['sorozat_cim']);
$mufaj = mysqli_real_escape_string($conn, $_POST['mufaj']);
$felhasznalonev = $_SESSION['felhasznalonev'];

//megnezzuk van e ilyen film mar
$proba = "SELECT * FROM sorozat WHERE sorozat_cim='$sorozat_cim'";
$letezik = mysqli_query($conn, $proba);

if (mysqli_num_rows($letezik) > 0) {
    echo "mar van"; //igazabol nem tortenik semmi - debug
} else {
    //1 uj sori beszurasa felh nev nelkul
    $ujsori = "INSERT INTO sorozat (sorozat_cim, mufaj, ertekeles_darab, ertekeles_osszeg) 
                          VALUES ('$sorozat_cim', '$mufaj', 0, 0)";

    if (mysqli_query($conn, $ujsori)) { //ha sikeres a sori beszurasa
        //2 adatokat a sorozat_ertekel tablaba tesszuk
        $ertekel = "INSERT INTO sorozat_ertekel (felhasznalonev, sorozat_cim) 
                              VALUES ('$felhasznalonev', '$sorozat_cim')";

        if (mysqli_query($conn, $ertekel)) { //ha ez is sikeres
            //3 a sort frissitjuk a felhnevvel
            $ujnev = "UPDATE sorozat SET felhasznalonev='$felhasznalonev' 
                                  WHERE sorozat_cim='$sorozat_cim'";

            if (mysqli_query($conn, $ujnev)) {
                echo "siker"; //deb
            } else {
                echo "nooooooooo: " . mysqli_error($conn); //edb
            }
        } else { //debug
            echo "sori_ertekel rossz: " . mysqli_error($conn);
        }
    } else { //debuh
        echo "a sori rossz: " . mysqli_error($conn);
    }
}

// kapcs zar
mysqli_close($conn);

//vissza
header("Location: ../php/sorozatok.php");
exit();