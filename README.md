# Adatbazisok
Databases

Ez a repository tartalmazza 2024/2025/1-es félévi adatbázisprojektem.

Az alkalmazás PHP nyelven (PHP 5.6) lett megvalósítva, a grafikus interfész HTML-lel (HTML 5) és CSS-sel. Az adatbázishoz MariaDB-t használtam, a MySQL szerverhez való kapcsolódáshoz MySQLi-t és PDO-t is használtam.

A feladatkiírás a következő volt:

IMDB

Specifikáció:
Egy olyan alkalmazás, amely filmeket, sorozatokat és színészeket tart nyilván. Az alkalmazásba lehet regisztrálni. A belépett felhasználó értékelést adhat a filmekhez és sorozatokhoz. Továbbá a belépett felhasználók képesek új filmek és sorozatok felvételére is.

Tárolt adatok (nem feltétlen jelentenek önálló táblákat):
● Felhasználó: felhasználónév, jelszó, név
● Filmek: cím, játékidő, műfaj, megjelenés éve, értékelés
● Sorozatok: cím, műfaj, évadok, részek, értékelés
● Színészek: születési dátum, név, állampolgárság

Relációk az adatok között:
Egy színész több filmben/sorozatban is szerepelhet. Egy színész egy filmben/sorozatban több szerepet is játszhat.

---------------------------------------------------

This repository contains my database project for the 2024/2025/1 semester.
The application was developed in PHP (version 5.6), with the graphical interface implemented using HTML (HTML 5) and CSS. For the database, I used MariaDB, and to connect to the MySQL server, I utilized both MySQLi and PDO.

The assignment was as follows:
IMDB

Specification:
An application that tracks movies, series, and actors. Users can register in the application. Logged-in users can rate movies and series. Additionally, logged-in users are capable of adding new movies and series.

Stored Data (not necessarily as separate tables):
● User: username, password, name
● Movies: title, runtime, genre, release year, rating
● Series: title, genre, seasons, episodes, rating
● Actors: date of birth, name, nationality

Relationships between the data:
An actor can appear in multiple movies/series. An actor can play multiple roles in a single movie/series.
