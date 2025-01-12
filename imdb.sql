-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Nov 20. 09:16
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

  
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `imdb`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `felhasznalonev` varchar(50) NOT NULL,
  `jelszo` varchar(300) NOT NULL,
  `ember_nev` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`felhasznalonev`, `jelszo`, `ember_nev`) VALUES
('a', '$2y$10$Wi70afBwJsxLf3UVUdgFX.7xIxDKQ2OyhxEPAI5Bsr8KLmcJg17Ty', 'a');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `film`
--

CREATE TABLE `film` (
  `film_cim` varchar(100) NOT NULL,
  `megjelenes_eve` year(4) NOT NULL,
  `mufaj` varchar(50) NOT NULL,
  `jatekido` int(11) NOT NULL,
  `ertekeles_darab` int(11) NOT NULL DEFAULT 0,
  `ertekeles_osszeg` int(11) NOT NULL DEFAULT 0,
  `felhasznalonev` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `film`
--

INSERT INTO `film` (`film_cim`, `megjelenes_eve`, `mufaj`, `jatekido`, `ertekeles_darab`, `ertekeles_osszeg`, `felhasznalonev`) VALUES
('Batman: Assault on Arkham', '2014', 'Akció', 76, 0, 0, 'a'),
('Monty Python and the Holy Grail', '1975', 'Vígjáték', 92, 0, 0, 'a');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `filmben_szerepel`
--

CREATE TABLE `filmben_szerepel` (
  `film_cim` varchar(100) NOT NULL,
  `megjelenes_eve` year(4) NOT NULL,
  `szinesz_nev` varchar(100) NOT NULL,
  `szuletesi_datum` date NOT NULL,
  `filmszerep` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `filmben_szerepel`
--

INSERT INTO `filmben_szerepel` (`film_cim`, `megjelenes_eve`, `szinesz_nev`, `szuletesi_datum`, `filmszerep`) VALUES
('Batman: Assault on Arkham', '2014', 'Giancarlo Esposito', '1958-04-26', 'Black Spider'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'A hullaszállító'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Első paraszt'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Fejbólintó'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Maynard atya'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Mocsár vár őre'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Roger, a rekettyetermesztő'),
('Monty Python and the Holy Grail', '1975', 'Eric Idle', '1943-03-29', 'Sir Robin, a nem annyira bátor, mint Sir Lancelot'),
('Monty Python and the Holy Grail', '1975', 'John Cleese', '1939-10-27', 'A fecskeszakértő őr'),
('Monty Python and the Holy Grail', '1975', 'John Cleese', '1939-10-27', 'Fekete lovag'),
('Monty Python and the Holy Grail', '1975', 'John Cleese', '1939-10-27', 'Sir Lancelot, a bátor');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `film_ertekel`
--

CREATE TABLE `film_ertekel` (
  `felhasznalonev` varchar(50) NOT NULL,
  `film_cim` varchar(100) NOT NULL,
  `megjelenes_eve` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `film_ertekel`
--

INSERT INTO `film_ertekel` (`felhasznalonev`, `film_cim`, `megjelenes_eve`) VALUES
('a', 'Batman: Assault on Arkham', '2014'),
('a', 'Monty Python and the Holy Grail', '1975');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `resz`
--

CREATE TABLE `resz` (
  `resz_id` int(11) NOT NULL,
  `resz_cim` varchar(100) NOT NULL,
  `resz_evad` int(11) NOT NULL,
  `sorozat_cim` varchar(100) DEFAULT NULL,
  `felhasznalonev` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `resz`
--

INSERT INTO `resz` (`resz_id`, `resz_cim`, `resz_evad`, `sorozat_cim`, `felhasznalonev`) VALUES
(41, 'Uno', 1, 'Better Call Saul', 'a'),
(42, 'Mijo', 1, 'Better Call Saul', 'a'),
(43, 'Nacho', 1, 'Better Call Saul', 'a'),
(44, 'Switch', 2, 'Better Call Saul', 'a'),
(45, 'Cobbler', 2, 'Better Call Saul', 'a'),
(46, 'Mabel', 3, 'Better Call Saul', 'a'),
(47, 'Namaste', 5, 'Better Call Saul', 'a'),
(48, 'Bagman', 5, 'Better Call Saul', 'a'),
(49, 'Pilot', 1, 'Breaking Bad', 'a'),
(50, 'Cat\'s in the Bag...', 1, 'Breaking Bad', 'a'),
(51, 'Down', 2, 'Breaking Bad', 'a'),
(52, 'No Más', 3, 'Breaking Bad', 'a'),
(53, 'I.F.T.', 3, 'Breaking Bad', 'a'),
(54, 'Green Light', 3, 'Breaking Bad', 'a'),
(55, 'I see you', 3, 'Breaking Bad', 'a'),
(56, 'Felina', 5, 'Breaking Bad', 'a'),
(57, 'Taste of the King', 1, 'The Midnight Gospel', 'a'),
(58, 'Officers and Wolves', 1, 'The Midnight Gospel', 'a'),
(59, 'Hunters Without a Home', 1, 'The Midnight Gospel', 'a'),
(60, 'Blinded by My End', 1, 'The Midnight Gospel', 'a'),
(61, 'Annihilation of Joy', 1, 'The Midnight Gospel', 'a'),
(62, 'Vulture with Honor', 1, 'The Midnight Gospel', 'a'),
(63, 'Turtles of the Eclipse', 1, 'The Midnight Gospel', 'a'),
(64, 'Mouse of Silver', 1, 'The Midnight Gospel', 'a');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sorozat`
--

CREATE TABLE `sorozat` (
  `sorozat_cim` varchar(100) NOT NULL,
  `mufaj` varchar(50) NOT NULL,
  `ertekeles_darab` int(11) NOT NULL DEFAULT 0,
  `ertekeles_osszeg` int(11) NOT NULL DEFAULT 0,
  `felhasznalonev` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `sorozat`
--

INSERT INTO `sorozat` (`sorozat_cim`, `mufaj`, `ertekeles_darab`, `ertekeles_osszeg`, `felhasznalonev`) VALUES
('Better Call Saul', 'Dráma', 0, 0, 'a'),
('Breaking Bad', 'Dráma', 0, 0, 'a'),
('The Midnight Gospel', 'Animáció', 0, 0, 'a');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sorozatban_szerepel`
--

CREATE TABLE `sorozatban_szerepel` (
  `sorozat_cim` varchar(100) NOT NULL,
  `szinesz_nev` varchar(100) NOT NULL,
  `szuletesi_datum` date NOT NULL,
  `sorozatszerep` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `sorozatban_szerepel`
--

INSERT INTO `sorozatban_szerepel` (`sorozat_cim`, `szinesz_nev`, `szuletesi_datum`, `sorozatszerep`) VALUES
('Better Call Saul', 'Bob Odenkirk', '1962-10-22', 'Saul Goodman'),
('Better Call Saul', 'Giancarlo Esposito', '1958-04-26', 'Gus Fring'),
('Better Call Saul', 'Jonathan Banks', '1947-01-31', 'Mike Ehrmantraut'),
('Breaking Bad', 'Bob Odenkirk', '1962-10-22', 'Saul Goodman'),
('Breaking Bad', 'Jonathan Banks', '1947-01-31', 'Mike Ehrmantraut'),
('The Midnight Gospel', 'Duncan Trussell', '1974-04-20', 'Clancy Gilroy'),
('The Midnight Gospel', 'Maria Bamford', '1970-09-03', 'Butt Demon'),
('The Midnight Gospel', 'Phil Hendrie', '1952-09-01', 'Universe Simulator'),
('The Midnight Gospel', 'Stephen Root', '1951-11-17', 'Bill Taft');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sorozat_ertekel`
--

CREATE TABLE `sorozat_ertekel` (
  `felhasznalonev` varchar(50) NOT NULL,
  `sorozat_cim` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `sorozat_ertekel`
--

INSERT INTO `sorozat_ertekel` (`felhasznalonev`, `sorozat_cim`) VALUES
('a', 'Better Call Saul'),
('a', 'Breaking Bad'),
('a', 'The Midnight Gospel');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szinesz`
--

CREATE TABLE `szinesz` (
  `szinesz_nev` varchar(100) NOT NULL,
  `szuletesi_datum` date NOT NULL,
  `allampolgarsag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szinesz`
--

INSERT INTO `szinesz` (`szinesz_nev`, `szuletesi_datum`, `allampolgarsag`) VALUES
('Bob Odenkirk', '1962-10-22', 'amerikai'),
('Duncan Trussell', '1974-04-20', 'amerikai'),
('Eric Idle', '1943-03-29', 'brit'),
('Giancarlo Esposito', '1958-04-26', 'dán'),
('John Cleese', '1939-10-27', 'brit'),
('Jonathan Banks', '1947-01-31', 'amerikai'),
('Maria Bamford', '1970-09-03', 'amerikai'),
('Phil Hendrie', '1952-09-01', 'amerikai'),
('Stephen Root', '1951-11-17', 'amerikai');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`felhasznalonev`);

--
-- A tábla indexei `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`film_cim`,`megjelenes_eve`),
  ADD KEY `film_felhasznalonev_fk` (`felhasznalonev`),
  ADD KEY `film_cim` (`film_cim`,`megjelenes_eve`);

--
-- A tábla indexei `filmben_szerepel`
--
ALTER TABLE `filmben_szerepel`
  ADD PRIMARY KEY (`film_cim`,`megjelenes_eve`,`szinesz_nev`,`szuletesi_datum`,`filmszerep`),
  ADD KEY `szuletesi_datum` (`szuletesi_datum`),
  ADD KEY `film_cim` (`film_cim`,`megjelenes_eve`),
  ADD KEY `fk_szinesz_nev` (`szinesz_nev`);

--
-- A tábla indexei `film_ertekel`
--
ALTER TABLE `film_ertekel`
  ADD PRIMARY KEY (`felhasznalonev`,`film_cim`,`megjelenes_eve`),
  ADD KEY `film_ertekel_film_cim_fk` (`film_cim`,`megjelenes_eve`);

--
-- A tábla indexei `resz`
--
ALTER TABLE `resz`
  ADD PRIMARY KEY (`resz_id`),
  ADD KEY `resz_felhasznalonev_fk` (`felhasznalonev`),
  ADD KEY `resz_sorozat_cim_fk` (`sorozat_cim`);

--
-- A tábla indexei `sorozat`
--
ALTER TABLE `sorozat`
  ADD PRIMARY KEY (`sorozat_cim`),
  ADD KEY `sorozat_felhasznalonev_fk` (`felhasznalonev`);

--
-- A tábla indexei `sorozatban_szerepel`
--
ALTER TABLE `sorozatban_szerepel`
  ADD PRIMARY KEY (`sorozat_cim`,`szinesz_nev`,`szuletesi_datum`,`sorozatszerep`),
  ADD KEY `szinesz_nev` (`szinesz_nev`),
  ADD KEY `szuletesi_datum` (`szuletesi_datum`);

--
-- A tábla indexei `sorozat_ertekel`
--
ALTER TABLE `sorozat_ertekel`
  ADD PRIMARY KEY (`felhasznalonev`,`sorozat_cim`),
  ADD KEY `sorozat_ertekel_sorozat_cim_fk` (`sorozat_cim`);

--
-- A tábla indexei `szinesz`
--
ALTER TABLE `szinesz`
  ADD PRIMARY KEY (`szinesz_nev`,`szuletesi_datum`),
  ADD KEY `szuletesi_datum` (`szuletesi_datum`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `resz`
--
ALTER TABLE `resz`
  MODIFY `resz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_felhasznalonev_fk` FOREIGN KEY (`felhasznalonev`) REFERENCES `film_ertekel` (`felhasznalonev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `filmben_szerepel`
--
ALTER TABLE `filmben_szerepel`
  ADD CONSTRAINT `fk_film_megjelenes` FOREIGN KEY (`film_cim`,`megjelenes_eve`) REFERENCES `film` (`film_cim`, `megjelenes_eve`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_szinesz_nev` FOREIGN KEY (`szinesz_nev`) REFERENCES `szinesz` (`szinesz_nev`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_szuldatum` FOREIGN KEY (`szuletesi_datum`) REFERENCES `szinesz` (`szuletesi_datum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `film_ertekel`
--
ALTER TABLE `film_ertekel`
  ADD CONSTRAINT `film_ertekel_felhasznalonev_fk` FOREIGN KEY (`felhasznalonev`) REFERENCES `felhasznalo` (`felhasznalonev`) ON UPDATE CASCADE,
  ADD CONSTRAINT `film_ertekel_film_cim_fk` FOREIGN KEY (`film_cim`,`megjelenes_eve`) REFERENCES `film` (`film_cim`, `megjelenes_eve`) ON UPDATE CASCADE;

--
-- Megkötések a táblához `resz`
--
ALTER TABLE `resz`
  ADD CONSTRAINT `resz_felhasznalonev_fk` FOREIGN KEY (`felhasznalonev`) REFERENCES `sorozat` (`felhasznalonev`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resz_sorozat_cim_fk` FOREIGN KEY (`sorozat_cim`) REFERENCES `sorozat` (`sorozat_cim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `sorozat`
--
ALTER TABLE `sorozat`
  ADD CONSTRAINT `sorozat_felhasznalonev_fk` FOREIGN KEY (`felhasznalonev`) REFERENCES `sorozat_ertekel` (`felhasznalonev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `sorozatban_szerepel`
--
ALTER TABLE `sorozatban_szerepel`
  ADD CONSTRAINT `sorozatban_szerepel_ibfk_1` FOREIGN KEY (`szinesz_nev`) REFERENCES `szinesz` (`szinesz_nev`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sorozatban_szerepel_ibfk_2` FOREIGN KEY (`szuletesi_datum`) REFERENCES `szinesz` (`szuletesi_datum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sorozatban_szerepel_ibfk_3` FOREIGN KEY (`sorozat_cim`) REFERENCES `sorozat` (`sorozat_cim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `sorozat_ertekel`
--
ALTER TABLE `sorozat_ertekel`
  ADD CONSTRAINT `sorozat_ertekel_felhasznalonev_fk` FOREIGN KEY (`felhasznalonev`) REFERENCES `felhasznalo` (`felhasznalonev`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sorozat_ertekel_sorozat_cim_fk` FOREIGN KEY (`sorozat_cim`) REFERENCES `sorozat` (`sorozat_cim`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
