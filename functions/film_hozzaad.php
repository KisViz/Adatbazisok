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
$film_cim = mysqli_real_escape_string($conn, $_POST['film_cim']);
$megjelenes_eve = mysqli_real_escape_string($conn, $_POST['megjelenes_eve']);
$mufaj = mysqli_real_escape_string($conn, $_POST['mufaj']);
$jatekido = mysqli_real_escape_string($conn, $_POST['jatekido']);
$felhasznalonev = $_SESSION['felhasznalonev'];

//megnezzuk van e ilyen film mar
$proba = "SELECT * FROM film WHERE film_cim='$film_cim' AND megjelenes_eve='$megjelenes_eve'";
$letezik = mysqli_query($conn, $proba);

if (mysqli_num_rows($letezik) > 0) {
    echo "mar van"; //igazabol nem tortenik semmi - debug
} else {
    //1 uj film beszurasa felh nev nelkul
    $ujfilm = "INSERT INTO film (film_cim, megjelenes_eve, mufaj, jatekido, ertekeles_darab, ertekeles_osszeg) 
                          VALUES ('$film_cim', '$megjelenes_eve', '$mufaj', '$jatekido', 0, 0)";

    if (mysqli_query($conn, $ujfilm)) { //ha sikeres a film beszurasa
        //2 adatokat a film_ertekel tablaba tesszuk
        $ertekel = "INSERT INTO film_ertekel (felhasznalonev, film_cim, megjelenes_eve) 
                              VALUES ('$felhasznalonev', '$film_cim', '$megjelenes_eve')";

        if (mysqli_query($conn, $ertekel)) { //ha ez is sikeres
            //3 a filmet frissitjuk a felhnevveé
            $ujnev = "UPDATE film SET felhasznalonev='$felhasznalonev' 
                                  WHERE film_cim='$film_cim' AND megjelenes_eve='$megjelenes_eve'";

            if (mysqli_query($conn, $ujnev)) {
                echo "siker"; //deb
            } else {
                echo "nooooooooo: " . mysqli_error($conn); //edb
            }
        } else { //debug
            echo "film_ertekel rossz: " . mysqli_error($conn);
        }
    } else { //debuh
        echo "a film rossz: " . mysqli_error($conn);
    }
}

// kapcs zar
mysqli_close($conn);

//vissza
header("Location: ../php/filmek.php");
exit();