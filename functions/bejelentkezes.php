<?php

function uj_bejelentkezes($felhasznalonev, $jelszo) {

    if (!($conn = imdb_csatlakozas())) { //ha nem sikerult csatlakozni, akkor kilepunk
        die("Hiba a csatlakozásnál");
    }

    //kikeressuk a jelyszavunk
    $stmt = $conn->prepare('SELECT jelszo FROM FELHASZNALO WHERE felhasznalonev = :felhasznalonev'); //PHP Data Objects
    $stmt->bindParam(':felhasznalonev', $felhasznalonev, PDO::PARAM_STR); //bekotjuk a parametert
    $stmt->execute(); //futtatjuk az utasitast

    //asszoc tombben elvesszuk az eredmenyt
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //ha van adat és jo a jelszo akkor orulunk
    if ($row && password_verify($jelszo, $row['jelszo'])) {
        $stmt = null;
        $conn = null;
        return true;
    } else {
        $stmt = null;
        $conn = null;
        return false;
    }

}

