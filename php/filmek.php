<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmek</title>
    <link rel="stylesheet" href="../css/filmek.css">
</head>
<body>
<?php include_once 'header.php'; ?>

<section>
    <?php if (isset($_SESSION['felhasznalonev'])) {
        echo '<h2>Új film felvétele</h2>
    <div class="container">
        <form action="../functions/film_hozzaad.php" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="film_cim">Film címe</label>
                    <input type="text" id="film_cim" name="film_cim" required placeholder="Írd be a film címét">
                </div>
                <div class="form-group">
                    <label for="megjelenes_eve">Megjelenés éve</label>
                    <input type="text" id="megjelenes_eve" name="megjelenes_eve" required placeholder="Írd be a megjelenés évét">
                </div>
                <div class="form-group">
                    <label for="mufaj">Műfaj</label>
                    <input type="text" id="mufaj" name="mufaj" required placeholder="Írd be a műfajt">
                </div>
                <div class="form-group">
                    <label for="jatekido">Játékidő</label>
                    <input type="text" id="jatekido" name="jatekido" required placeholder="Írd be a játékidőt">
                </div>
            </div>
            <button type="submit">Film hozzáadása</button>
        </form>
    </div>';
    } ?>
</section>

<main class="main-container">
    <div class="main-content">

        <?php
        echo '<h1>Filmek</h1>';
        //cstlakozazs az adatbhez
        $conn = mysqli_connect('localhost', 'root', '') or die("Hibás csatlakozás!");

        //karakterkodolas
        mysqli_query($conn, 'SET NAMES UTF8');
        mysqli_query($conn, "SET character_set_results=utf8");
        mysqli_set_charset($conn, 'utf8');

        if (mysqli_select_db($conn, 'imdb')) { //ha sikeres a csatl
            //lekerdezzuk a filmeket a filmek tablabol

            $sql = "SELECT film_cim, megjelenes_eve, mufaj, jatekido, ertekeles_darab, ertekeles_osszeg  FROM film;";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!'); //vegrehajtasa

            //tabla  fejlec
            echo '<table>';
            echo '<tr>';
            echo '<th>Cím</th>';
            echo '<th>Megjelenés éve</th>';
            echo '<th>Műfaj</th>';
            echo '<th>Játékidő (perc)</th>';
            echo '<th>Értékelés</th>';
            if (isset($_SESSION['felhasznalonev'])) {
                echo '<th>Értékelem</th>';
            }
            echo '</tr>';

            //sorokban az adatok
            while (($current_row = mysqli_fetch_assoc($res)) != null) { //asszoc tombben vannak a sorok
                echo '<tr>';
                echo '<td>' . $current_row["film_cim"] . '</td>';
                echo '<td>' . $current_row["megjelenes_eve"] . '</td>';
                echo '<td>' . $current_row["mufaj"] . '</td>';
                echo '<td>' . $current_row["jatekido"] . '</td>';
                echo '<td>';
                if ($current_row["ertekeles_darab"] == 0) { //0val osztas
                    echo 'Még nincs értékelés </td>';
                } else {
                    echo "10/" . round($current_row["ertekeles_osszeg"] / $current_row["ertekeles_darab"], 1) . '</td>';
                }

                if (isset($_SESSION['felhasznalonev'])) {//ertekeles
                    echo '<td>';
                    echo '<form action="../functions/film_ertekel.php" method="post">';
                    echo '<div class="ert">';
                    echo '<input type="hidden" name="film_cim" value="' . $current_row["film_cim"] . '">';
                    echo '<input type="hidden" name="megjelenes_eve" value="' . $current_row["megjelenes_eve"] . '">';
                    echo '<input type="number" name="ertekeles" min="1" max="10" required placeholder="1-10">';
                    echo '<button type="submit">Mehet</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</td>';
                }

                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res); //memoria folszabaditas
        } else { //ha nem tudtunk csatl az adatbhez
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        mysqli_close($conn); //lezarjuk a kapcsolatot

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
            <h2>Érdekesség: Adott filben szereplő színészek átlag életkora</h2>
            <table>
                <thead>
                <tr>
                    <th>Film</th>
                    <th>Átlag életkor</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT film.film_cim, AVG(YEAR(FROM_DAYS(DATEDIFF(CURDATE(),szerep.szuletesi_datum)))) AS atlagos_eletkor
                          FROM film
                          JOIN (
                              SELECT DISTINCT film_cim, megjelenes_eve, szinesz_nev, szuletesi_datum
                              FROM filmben_szerepel
                          ) szerep ON film.film_cim = szerep.film_cim AND film.megjelenes_eve = szerep.megjelenes_eve
                          JOIN szinesz ON szerep.szinesz_nev = szinesz.szinesz_nev AND szerep.szuletesi_datum = szinesz.szuletesi_datum
                          GROUP BY film.film_cim;";
                //allekerdezessel kigyujtjuk azokat az adatokat amik KULONBOZNEK
                //folekerdezesben kiszedjuk a cimet atlag eletkort: mostani es masik datum kulonbsege, de az napban adja vissza, azt datumma, annak az eve, azoknak az atlaga (gyonyoru)
                //az osszekapcsolt tablakbol
                //cim szerint rendezve

                $result = mysqli_query($conn, $query); //elvegezzuk
                while ($row = mysqli_fetch_assoc($result)) {
                    $kor = round($row['atlagos_eletkor'], 1);
                    echo "<tr><td>{$row['film_cim']}</td><td>{$kor}</td></tr>";
                }

                mysqli_free_result($result); //memoria folszabaditas
                mysqli_close($conn);//zarjuk
                ?>
                </tbody>
            </table>
        </div>


        <div class="szin2">
            <h2>Top 5 easteregg, amit nem vettél észre az Egy bogár élete filmben</h2>
            <img src="../img/debugger.webp" alt="Breaking news">
        </div>

    </aside>

</main>

<?php include_once 'footer.php'; ?>
</body>
</html>
