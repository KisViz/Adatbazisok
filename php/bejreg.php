<?php
session_start();

$error = '';

include_once("../functions/regisztracio.php"); //a reg ebben van
include_once("../functions/bejelentkezes.php"); //a login ebben van

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") { //whitespace ellenorzese
        $uzenet = "Adja meg az összes adatot!";

    } elseif (isset($_POST['regisztracio'])) { //ha reg van nyomva
        //kiszedjuk az adatokaht
        $nev = $_POST['nev'];
        $felhasznalonev = $_POST['felhasznalonev'];
        $jelszo = $_POST['jelszo'];

        //es ha be vannak allitva
        if (isset($nev) && isset($jelszo) && isset($felhasznalonev)) {
            //megprobaljuk menteni
            $sikeres = uj_regisztracio($nev, $felhasznalonev, $jelszo);
            //kiirjuk, hogy szotyi van
            if ($sikeres == true) {
                $error = "Sikeres regisztráció!";
            } else {
                $error = "A felhasználónév már foglalt!";
            }
        } else {
            $error = "Nincs beállítva valamely érték";
        }

    } elseif (isset($_POST['bejelentkezes'])) {

        if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") { //whitespace ellenorzese
            $uzenet = "Adja meg az összes adatot!";
        } else {

            $felhasznalonev = $_POST['felhasznalonev'];
            $jelszo = $_POST['jelszo'];

            if (uj_bejelentkezes($felhasznalonev, $jelszo)) {
                $_SESSION['felhasznalonev'] = $felhasznalonev;
                $error = "Sikeres bejelentkezés!";
            } else {
                $error = "Hibás felhasználónév vagy jelszó!";
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés/Regisztráció</title>
    <link rel="stylesheet" href="../css/bejreg.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <div class="container">
        <h2>Bejelentkezés</h2>
        <form action="bejreg.php" method="post" accept-charset="UTF-8">
            <input type="text" name="felhasznalonev" placeholder="Felhasználónév" required>
            <input type="password" name="jelszo" placeholder="Jelszó" required>
            <button type="submit" name="bejelentkezes">Bejelentkezés</button>
        </form>
        <h2>Regisztráció</h2>
        <form action="bejreg.php" method="post" accept-charset="UTF-8">
            <input type="text" name="nev" placeholder="Név" required>
            <input type="text" name="felhasznalonev" placeholder="Felhasználónév" required>
            <input type="password" name="jelszo" placeholder="Jelszó" required>
            <button type="submit" name="regisztracio">Regisztráció</button>
        </form>
        <?php if ($error === "Sikeres regisztráció!" || $error === "Sikeres bejelentkezés!") { ?>
            <p class="joerror"><?= $error ?></p>
        <?php } else { ?>
            <p class="rosszerror"><?= $error ?></p>
        <?php } ?>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
