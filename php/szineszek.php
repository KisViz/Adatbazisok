<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Színészek</title>
    <link rel="stylesheet" href="../css/szineszek.css">
</head>
<body>
<?php include_once 'header.php'; ?>

<?php
if (isset($_SESSION['felhasznalonev'])) {
    echo '<h2>Új színész felvétele</h2>
    <div class="container">
        <form action="../functions/szinesz_hozzaad.php" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="szinesz_nev">Színész neve</label>
                    <input type="text" id="szinesz_nev" name="szinesz_nev" required placeholder="Írd be a színész nevét">
                </div>
                <div class="form-group">
                    <label for="szuletesi_datum">Születési dátuma</label>
                    <input type="date" id="szuletesi_datum" name="szuletesi_datum" required placeholder="Írd be a születési dátumát">
                </div>
                <div class="form-group">
                    <label for="allampolgarsag">Állampolgársága</label>
                    <input type="text" id="allampolgarsag" name="allampolgarsag" required placeholder="Írd be az állampolgárságát">
                </div>
            </div>
            <button type="submit">Színész hozzáadása</button>
        </form>
    </div>
    
    <h2>Új filmszerep felvétele</h2>
    <div class="container-szerep">
        <form action="../functions/filmszerep_hozzaad.php" method="post">
                <div class="form-group-szerep">
                    <label>Színész</label>
                    <select name="valasztott_szinesz">';
    //adatb kapcsolat
    $conn = mysqli_connect('localhost', 'root', '', 'imdb') or die("Hibás csatlakozás!");

    //karakter kodolas
    mysqli_set_charset($conn, 'utf8');

    $szineszek = mysqli_query($conn, "SELECT szinesz_nev, szuletesi_datum, CONCAT(szinesz_nev, ' - ', szuletesi_datum, ' - ', allampolgarsag) AS adatok FROM szinesz") or die(mysqli_error($conn));
    //szineszekeb beletesszuk a nevet, datumot es a stringbe osszefuzott adtokat a szinesz tablabol

    while ($egySor = mysqli_fetch_assoc($szineszek)) {
        echo '<option value="' . $egySor["szinesz_nev"] . '|' . $egySor["szuletesi_datum"] . '">' . $egySor["adatok"] . '</option>';
    }
    mysqli_free_result($szineszek);
    echo ' </select>
                    <label>Film</label>
                        <select name="valasztott_film">';
    $filmek = mysqli_query($conn, "SELECT film_cim, megjelenes_eve, CONCAT(film_cim, ' - ', megjelenes_eve) AS adatok FROM film") or die(mysqli_error($conn));
    //ugyan igy fuzogetjuk a szineszeket

    while ($egySor = mysqli_fetch_assoc($filmek)) {
        echo '<option value="' . $egySor["film_cim"] . "|" . $egySor["megjelenes_eve"] . '">' . $egySor["adatok"] . '</option>';
    }
    mysqli_free_result($filmek);
    mysqli_close($conn);
    echo ' </select>
                    <label for="szerep">Szerep</label>
                    <input type="text" id="filmszerep" name="filmszerep" required placeholder="Írd be a szerepet">
            </div>
            <button type="submit">Szerep hozzáadása</button>
        </form>
    </div>

    <h2>Új sorozatszerep felvétele</h2>
    <div class="container-szerep">
        <form action="../functions/sorozatszerep_hozzaad.php" method="post">
                <div class="form-group-szerep">
                    <label>Színész</label>
                    <select name="valasztott_szinesz">';
    //adatb kapcsolat
    $conn = mysqli_connect('localhost', 'root', '', 'imdb') or die("Hibás csatlakozás!");

    //karakter kodolas
    mysqli_set_charset($conn, 'utf8');

    $szineszek = mysqli_query($conn, "SELECT szinesz_nev, szuletesi_datum, CONCAT(szinesz_nev, ' - ', szuletesi_datum, ' - ', allampolgarsag) AS adatok FROM szinesz") or die(mysqli_error($conn));
    //na megegyszer a szineszeknel

    while ($egySor = mysqli_fetch_assoc($szineszek)) {
        echo '<option value="' . $egySor["szinesz_nev"] . '|' . $egySor["szuletesi_datum"] . '">' . $egySor["adatok"] . '</option>';
    }
    mysqli_free_result($szineszek);
    echo ' </select>
                     <label>Sorozat</label>
                     <select name="valasztott_sorozat">';
    $sorik = mysqli_query($conn, "SELECT sorozat_cim FROM sorozat") or die(mysqli_error($conn));
    //es a sorozatoknal is

    while ($egySor = mysqli_fetch_assoc($sorik)) {
        echo '<option value="' . $egySor["sorozat_cim"] . '">' . $egySor["sorozat_cim"] . '</option>';
    }
    mysqli_free_result($sorik);
    mysqli_close($conn);
    echo ' </select>
                    <label for="szerep">Szerep</label>
                    <input type="text" id="soriszerep" name="soriszerep" required placeholder="Írd be a szerepet">
            </div>
            <button type="submit">Szerep hozzáadása</button>
        </form>
    </div>';
} ?>

<main class="main-container">
    <div class="main-content">

        <?php
        echo '<h1>Színészek</h1>';
        //cstl az adatbhez
        $conn = mysqli_connect('localhost', 'root', '') or die("Hibás csatlakozás!");

        //karkosolass
        mysqli_query($conn, 'SET NAMES UTF8');
        mysqli_query($conn, "SET character_set_results=utf8");
        mysqli_set_charset($conn, 'utf8');

        if (mysqli_select_db($conn, 'imdb')) { //ha sikeres csatl

            //szineszeket lekerjuk
            $sql = "SELECT szinesz_nev, szuletesi_datum, allampolgarsag FROM szinesz";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!'); //vegrehajt


            while (($current_row = mysqli_fetch_assoc($res)) != null) { //asszoctben sorok

                //siorokban az adatok
                echo '<table>';
                echo '<tr>';
                echo '<th>Név</th>';
                echo '<th>Születési dátum</th>';
                echo '<th>Állampolgárság</th>';
                echo '</tr>';


                echo '<tr>';
                echo '<td>' . $current_row["szinesz_nev"] . '</td>';
                echo '<td>' . $current_row["szuletesi_datum"] . '</td>';
                echo '<td>' . $current_row["allampolgarsag"] . '</td>';
                echo '</tr>';

                //a szinesz filmjeinek lekerese
                $szinesznev = $current_row["szinesz_nev"];
                $szuldatum = $current_row["szuletesi_datum"];
                $sql_film = "SELECT film_cim, filmszerep
                             FROM filmben_szerepel WHERE szinesz_nev = '$szinesznev' AND szuletesi_datum = '$szuldatum'
                             ORDER BY film_cim";

                $res_film = mysqli_query($conn, $sql_film) or die('Hibás utasítás a részek lekérdezésénél!');

                if (mysqli_num_rows($res_film) > 0) { //csak akkor jelenjen mg, ha van adat

                    echo '<tr><td colspan="3">';
                    echo '<table class="evadok">';
                    echo '<tr><th>Film</th><th>Szerep</th></tr>';

                    while (($evad_film = mysqli_fetch_assoc($res_film)) != null) {
                        echo '<tr>';
                        echo '<td>' . $evad_film["film_cim"] . '</td>';
                        echo '<td>' . $evad_film["filmszerep"] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                    echo '</td></tr>';
                }

                //sorik lekerese
                $sql_sori = "SELECT sorozat_cim, sorozatszerep
                             FROM sorozatban_szerepel WHERE szinesz_nev = '$szinesznev' AND szuletesi_datum = '$szuldatum'
                             ORDER BY sorozat_cim";
                $res_sori = mysqli_query($conn, $sql_sori) or die('Hibás utasítás a részek lekérdezésénél!');

                if (mysqli_num_rows($res_sori) > 0) { //cdak ha van
                    echo '<tr><td colspan="3">';
                    echo '<table class="evadok">';
                    echo '<tr><th>Sorozat</th><th>Szerep</th></tr>';

                    while (($evad_sori = mysqli_fetch_assoc($res_sori)) != null) {
                        echo '<tr>';
                        echo '<td>' . $evad_sori["sorozat_cim"] . '</td>';
                        echo '<td>' . $evad_sori["sorozatszerep"] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                    echo '</td></tr>';
                }
                echo '</table>';
                mysqli_free_result($res_film); //mem felsz
                mysqli_free_result($res_sori); //mem felsz
            }

            mysqli_free_result($res); //mem felsz
        } else { //skertelen csazl
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        mysqli_close($conn); //kapcs zar
        ?>

    </div>

    <aside class="sidebar">

        <div class="szin">
            <?php
            $conn = mysqli_connect('localhost', 'root', '') or die("Hibás csatlakozás!");
            mysqli_query($conn, 'SET NAMES UTF8');
            mysqli_query($conn, "SET character_set_results=utf8");
            mysqli_set_charset($conn, 'utf8');
            mysqli_select_db($conn, 'imdb');
            ?>
            <h2>Érdekesség: A színészek hány szerepet játszottak karrierjük során sorozatokban</h2>
            <table>
                <thead>
                <tr>
                    <th>Színész neve</th>
                    <th>Hányszor szerepelt</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT szinesz.szinesz_nev, szinesz.szuletesi_datum, COUNT(sorozatban_szerepel.sorozat_cim) AS szereplesek_szama
                          FROM szinesz 
                          JOIN sorozatban_szerepel ON szinesz.szinesz_nev = sorozatban_szerepel.szinesz_nev AND szinesz.szuletesi_datum = sorozatban_szerepel.szuletesi_datum
                          JOIN sorozat ON sorozatban_szerepel.sorozat_cim = sorozat.sorozat_cim
                          GROUP BY szinesz.szinesz_nev
                          ORDER BY szereplesek_szama DESC;";
                //kivalasztjuk a szinesz nevet és szereplesek szamar
                //szinesz tbalabol valogatunk
                //osszekapcs a szerepelt szineszzel
                //es a sorozatat a szepelllel
                //szinesz nevenkent nezzze
                //és szereples szam szerint csokk


                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['szinesz_nev']}</td><td>{$row['szereplesek_szama']}</td></tr>";
                }

                mysqli_free_result($result); //meme felsz
                mysqli_close($conn); //zarsz
                ?>
                </tbody>
            </table>
        </div>

        <div class="szin2">
            <?php
            $conn = mysqli_connect('localhost', 'root', '') or die("Hibás csatlakozás!");
            mysqli_query($conn, 'SET NAMES UTF8');
            mysqli_query($conn, "SET character_set_results=utf8");
            mysqli_set_charset($conn, 'utf8');
            mysqli_select_db($conn, 'imdb');
            ?>
            <h2>Érdekesség: A színészek hány szerepet játszottak karrerjük során filmekben</h2>
            <table>
                <thead>
                <tr>
                    <th>Színész neve</th>
                    <th>Hányszor szerepelt</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT szinesz.szinesz_nev, szinesz.szuletesi_datum, COUNT(filmben_szerepel.film_cim) AS szereplesek_szama
                          FROM szinesz
                          JOIN filmben_szerepel ON szinesz.szinesz_nev = filmben_szerepel.szinesz_nev AND szinesz.szuletesi_datum = filmben_szerepel.szuletesi_datum
                          JOIN film ON filmben_szerepel.film_cim = film.film_cim
                          GROUP BY szinesz.szinesz_nev
                          ORDER BY szereplesek_szama DESC;";
                //kivalasztjuk a szinesz nevet és szereplesek szamar
                //szinesz tbalabol valogatunk
                //osszekapcs a szerepelt szineszzel
                //es a filmet a szepelllel
                //szinesz nevenkent nezzze
                //és szereples szam szerint csokk

                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['szinesz_nev']}</td><td>{$row['szereplesek_szama']}</td></tr>";
                }

                mysqli_free_result($result); //meme felsz
                mysqli_close($conn);//zast
                ?>
                </tbody>
            </table>
        </div>

        <div class="szin2">
            <h2>Breaking news: Chuck Norris is szerepelhet a Terminátor 8-ban</h2>
            <img src="../img/terminator8.jpg" alt="Breaking news">
        </div>

        <div class="szin2">
            <h2>A kő-papír-olló gyógyítási technika</h2>
            <img src="../img/chucksissors.jpg" alt="Breaking news">
        </div>

    </aside>

</main>

<?php include_once 'footer.php'; ?>
</body>
</html>
