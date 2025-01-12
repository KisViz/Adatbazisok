<?php

function imdb_csatlakozas() { //csatlakozik az adatbhez
    try {
        $conn = new PDO("mysql:host=localhost;dbname=IMDB;charset=utf8", "root", "");
    } catch (PDOException $ex) {
        echo "Csatlakozási hiba: " . $ex->getMessage();
    }
    return $conn; //pdo: php data object

}

function uj_regisztracio($ember_nev, $felhasznalonev, $jelszo) {

    if ( !($conn = imdb_csatlakozas()) ) { //ha nem sikerult csatlakozni, akkor kilepunk
        die("Hiba a csatlakozásnál");
    }



    //meglevo felsznalonev ellenorzese
    //kiszedjuk az osszes megadott felhasznalonevet
    $stmt = $conn->prepare('SELECT COUNT(*) FROM FELHASZNALO WHERE felhasznalonev = :felhasznalonev'); //elokeszitjuk az utasitast
    $stmt->bindParam(':felhasznalonev', $felhasznalonev, PDO::PARAM_STR); //bekotjuk a parametert
    $stmt->execute(); //futtatjuk az utasitast
    $count = $stmt->fetchColumn(); //elvesszuk a sort (ami most a count* eredenye)

    if ($count > 0) { //ha mar egyaltalan van sor, akkor bajsz
        return false;
    }

    //elokeszitjuk az utasitast
    $stmt = $conn->prepare('INSERT INTO FELHASZNALO(felhasznalonev, jelszo, ember_nev) VALUES (:felhasznalonev, :jelszo, :ember_nev)');
    //titkoszitjuk a jszt
    $hashelt_jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
    //bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
    $stmt->bindParam(':felhasznalonev',$felhasznalonev, PDO::PARAM_STR, 50);
    $stmt->bindParam(':jelszo', $hashelt_jelszo, PDO::PARAM_STR, 300);
    $stmt->bindParam(':ember_nev',  $ember_nev, PDO::PARAM_STR, 100);

    //futtatjuk az sql utasitast
    $stmt->execute();

    //eroforrasokst felszabadizjuk
    $stmt = null;
    $conn = null;
    return true;
}

