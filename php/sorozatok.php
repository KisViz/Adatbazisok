<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorozatok</title>
    <link rel="stylesheet" href="../css/sorozatok.css">
</head>
<body>
<?php include_once 'header.php'; ?>

<section>
    <?php if (isset($_SESSION['felhasznalonev'])) {
        echo '<h2>Új sorozat felvétele</h2>
                <div class="container">
                    <form action="../functions/sorozat_hozzaad.php" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="sorozat_cim">Sorozat címe</label>
                                <input type="text" id="sorozat_cim" name="sorozat_cim" required placeholder="Írd be a sorozat címét">
                            </div>
                            <div class="form-group">
                                <label for="mufaj">Műfaj</label>
                                <input type="text" id="mufaj" name="mufaj" required placeholder="Írd be a műfajt">
                            </div>
                        </div>
                        <button type="submit">Sorozat hozzáadása</button>
                    </form>
                </div>';
    } ?>
</section>

<main class="main-container">
    <div class="main-content">


        <h1>Sorozatok</h1>
        <?php
        //csautl
        $conn = mysqli_connect('localhost', 'root', '') or die("Hibás csatlakozás!");

        //karkod
        mysqli_query($conn, 'SET NAMES UTF8');
        mysqli_query($conn, "SET character_set_results=utf8");
        mysqli_set_charset($conn, 'utf8');

        if (mysqli_select_db($conn, 'imdb')) { //ha sikeres a csatl
            //sorozatok lekeker
            $sql = "SELECT sorozat_cim, mufaj, ertekeles_darab, ertekeles_osszeg FROM sorozat;";
            $res = mysqli_query($conn, $sql) or die('Hibás utasítás!');


            while (($current_row = mysqli_fetch_assoc($res)) != null) { //asszocban az adatok


                echo '<table>';
                echo '<tr>';
                echo '<th>Cím</th>';
                echo '<th>Műfaj</th>';
                echo '<th>Értékelés</th>';
                if (isset($_SESSION['felhasznalonev'])) {
                    echo '<th>Értékelem</th>';
                }
                echo '</tr>';


                echo '<tr>';
                echo '<td>' . $current_row["sorozat_cim"] . '</td>';
                echo '<td>' . $current_row["mufaj"] . '</td>';
                echo '<td>';
                if ($current_row["ertekeles_darab"] == 0) { //nullaval ne osszon
                    echo 'Még nincs értékelés </td>';
                } else {
                    echo "10/" . round($current_row["ertekeles_osszeg"] / $current_row["ertekeles_darab"], 1) . '</td>';
                }
                if (isset($_SESSION['felhasznalonev'])) {
                    echo '<td>';
                    echo '<form action="../functions/sorozat_ertekel.php" method="post">';
                    echo '<div class="ert">';
                    echo '<input type="hidden" name="sorozat_cim" value="' . $current_row["sorozat_cim"] . '">';
                    echo '<input type="number" name="ertekeles" min="1" max="10" required placeholder="1-10">';
                    echo '<button type="submit">Mehet</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</td>';
                }
                echo '</tr>';


                //sorozat evadjai/reszei
                $sorozat_cim = $current_row["sorozat_cim"];
                $sql_evad = "SELECT resz_evad, resz_cim 
                             FROM resz WHERE sorozat_cim = '$sorozat_cim' 
                             ORDER BY resz_evad";
                //es evadonkent rendezi novekvobef
                $res_evad = mysqli_query($conn, $sql_evad) or die('Hibás utasítás a részek lekérdezésénél!');

                echo '<tr><td colspan="4">';
                echo '<table class="evadok">';
                echo '<tr><th>Évad</th><th>Cím</th></tr>';

                //az eved hozzaadas
                if (isset($_SESSION['felhasznalonev'])) {
                    echo '
                    <div class="container">
                        <h3>Új rész hozzáadása</h3>
                        <form action="../functions/resz_hozzaad.php" method="post">
                             <div class="form-row">
                    
                                <input type="hidden" name="sorozat_cim" value="' . $sorozat_cim . '">
            
                                <div class="form-group">
                                    <label for="evad">Évad</label>
                                    <input type="number" id="evad" name="evad" min="1" required placeholder="Írd be az évad számát">
                                </div>
                                <div class="form-group">
                                    <label for="resz_cim">Rész címe</label>
                                    <input type="text" id="resz_cim" name="resz_cim" required placeholder="Írd be a rész címét">
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="submit">Rész hozzáadása</button>
                            </div>
                        </form>
                    </div>';
                }

                //kiiratsa
                while (($evad_row = mysqli_fetch_assoc($res_evad)) != null) {
                    echo '<tr>';
                    echo '<td>' . $evad_row["resz_evad"] . '</td>';
                    echo '<td>' . $evad_row["resz_cim"] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</td></tr>';

                mysqli_free_result($res_evad);
            }
            echo '</table>';

            mysqli_free_result($res); //mme felsz

        } else { //ez meg a sikertelen csatl
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        mysqli_close($conn); //zar
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
            <h2>Érdekesség: Részek száma összesen, sorozatok műfajai szerint:</h2>
            <table>
                <thead>
                <tr>
                    <th>Műfaj</th>
                    <th>Részek száma</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT sorozat.mufaj, COUNT(resz.resz_id) AS reszek_szama
                          FROM sorozat
                          JOIN resz ON sorozat.sorozat_cim = resz.sorozat_cim
                          GROUP BY sorozat.mufaj;";
                //kivesszuk a mufajt es a reszek szamat a sorozatbol
                //kapcsoljuk a tablakat
                //csopi

                $result = mysqli_query($conn, $query); //elvegsze
                while ($row = mysqli_fetch_assoc($result)) { //aszocos adatos
                    if (isset($row['reszek_szama'])) {
                        echo "<tr><td>{$row['mufaj']}</td><td>{$row['reszek_szama']}</td></tr>";
                    }
                }
                mysqli_free_result($result); //memoria folszabaditas
                mysqli_close($conn);//zar
                ?>
                </tbody>
            </table>
        </div>

        <div class="szin2">
            <h2>Top 10 legroszabb sorozat, amit valaha láttál</h2>
            <img src="../img/chucktv.gif" alt="Breaking news">
        </div>

        <div class="szin2">
            <h2>Egy britt tudós coport megfejtette a piramisok építésének titkát</h2>
            <img src="../img/chuckpyreamid.jpg" alt="Breaking news">
        </div>
    </aside>
</main>


<?php include_once 'footer.php'; ?>
</body>
</html>
