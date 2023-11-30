-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Nov 2023 um 16:02
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `inventardb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ausleihe`
--

CREATE TABLE `ausleihe` (
  `ausleihid` int(11) NOT NULL,
  `rehanr` int(10) DEFAULT NULL,
  `mitarbeiterid` varchar(10) NOT NULL,
  `ausleihe` datetime DEFAULT NULL,
  `inventarid` varchar(20) NOT NULL,
  `zurueckgegeben` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `ausleihe`
--
DELIMITER $$
CREATE TRIGGER `Trueckgabehistory` AFTER DELETE ON `ausleihe` FOR EACH ROW BEGIN
    INSERT INTO
rueckgabehistory
(
    ausleihid,rehanr,mitarbeiterid,ausleihe,inventarid
)
VALUES
(
    OLD.ausleihid,
    OLD.rehanr,  
    OLD.mitarbeiterid,
    OLD.ausleihe,
    OLD.inventarid
  
);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inventar`
--

CREATE TABLE `inventar` (
  `inventarid` varchar(20) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `seriennr` varchar(50) NOT NULL,
  `kategorie` varchar(100) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'verfÃ¼gbar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `inventar`
--

INSERT INTO `inventar` (`inventarid`, `bezeichnung`, `seriennr`, `kategorie`, `status`) VALUES
('00023', 'Not7', '828382', 'Notebook', 'verfügbar'),
('12345', 'Lap1', 'A12345', 'Laptop', 'verfügbar'),
('23456', 'Lap2', 'A23456', 'Laptop', 'verfügbar'),
('34567', 'Note1', 'A34567', 'Notebook', 'verfügbar'),
('45678', 'Note2', 'A45678', 'Notebook', 'verfügbar'),
('55555', 'Lap9', '66557', 'Laptop', 'verfügbar'),
('56789', 'Note3', 'A56789', 'Notebook', 'verfügbar'),
('67890', 'Pres1', 'A67890', 'Presenter', 'verfügbar'),
('78901', 'Pres2', 'A78901', 'Presenter', 'verfügbar'),
('fffsr2r', '3r2rqr', 'qrqwrqw', 'qwrqwr', 'verfügbar');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitarbeiterinnen`
--

CREATE TABLE `mitarbeiterinnen` (
  `mitarbeiterid` varchar(10) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `abteilung` varchar(100) NOT NULL,
  `benutzername` varchar(10) NOT NULL,
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `mitarbeiterinnen`
--

INSERT INTO `mitarbeiterinnen` (`mitarbeiterid`, `vorname`, `nachname`, `abteilung`, `benutzername`, `passwort`) VALUES
('1', 'KursA', 'Max', 'Mustermann', 'Abteilung1', ''),
('2', 'KursB', 'Lisa', 'Lustig', 'Abteilung2', ''),
('3', 'KursC', 'Anna', 'Anders', 'Abteilung3', ''),
('77', 'KursA', 'Max', 'Mustermann', 'Abteilung1', ''),
('7799', 'KursA', 'Max', 'Mustermann', 'Abteilung1', ''),
('8999', 'KursC', 'Anna', 'Anders', '', ''),
('admin', 'admin', 'admin', 'admin', 'admin', '$2y$10$QNQTpn.yPaxtQllg1.kd1uhAarOllXggqkASA1o1VBs9ctjuJeama');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rehabilitandinnen`
--

CREATE TABLE `rehabilitandinnen` (
  `rehanr` int(10) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `kurs` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rehabilitandinnen`
--

INSERT INTO `rehabilitandinnen` (`rehanr`, `vorname`, `nachname`, `kurs`) VALUES
(1, 'Max', 'Mustermann', 'KursA'),
(2, 'Lisa', 'Lustig', 'KursB'),
(3, 'Anna', 'Anders', 'KursC'),
(12345, 'Max', 'Mustermann', 'Musterkurs'),
(67890, 'Martha', 'Musterfrau', 'Musterkurs');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rueckgabehistory`
--

CREATE TABLE `rueckgabehistory` (
  `rueckgabeid` int(11) NOT NULL,
  `inventarid` varchar(20) NOT NULL,
  `rehanr` int(10) NOT NULL,
  `mitarbeiterid` varchar(10) NOT NULL,
  `rueckgabe` timestamp NOT NULL DEFAULT current_timestamp(),
  `ausleihe` datetime NOT NULL,
  `ausleihid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rueckgabehistory`
--

INSERT INTO `rueckgabehistory` (`rueckgabeid`, `inventarid`, `rehanr`, `mitarbeiterid`, `rueckgabe`, `ausleihe`, `ausleihid`) VALUES
(46, '44444', 12345, 'admin', '2023-09-11 12:26:00', '2023-09-11 14:25:53', 89),
(47, '12345', 67890, 'admin', '2023-09-14 07:25:35', '2023-09-14 09:25:19', 90),
(48, '12345', 67890, 'admin', '2023-09-15 07:36:06', '2023-09-15 09:36:00', 91),
(49, '12345', 12345, 'admin', '2023-09-20 09:17:14', '2023-09-20 11:15:23', 92),
(50, '12345', 12345, 'admin', '2023-09-20 09:19:41', '2023-09-20 11:16:04', 93),
(51, '12345', 12345, 'admin', '2023-09-20 09:20:25', '2023-09-20 11:20:19', 94);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ausleihe`
--
ALTER TABLE `ausleihe`
  ADD PRIMARY KEY (`ausleihid`),
  ADD KEY `fk_inventarid` (`inventarid`),
  ADD KEY `fk_rehanr` (`rehanr`),
  ADD KEY `mitarbeiterid` (`mitarbeiterid`);

--
-- Indizes für die Tabelle `inventar`
--
ALTER TABLE `inventar`
  ADD PRIMARY KEY (`inventarid`);

--
-- Indizes für die Tabelle `mitarbeiterinnen`
--
ALTER TABLE `mitarbeiterinnen`
  ADD PRIMARY KEY (`mitarbeiterid`);

--
-- Indizes für die Tabelle `rehabilitandinnen`
--
ALTER TABLE `rehabilitandinnen`
  ADD PRIMARY KEY (`rehanr`);

--
-- Indizes für die Tabelle `rueckgabehistory`
--
ALTER TABLE `rueckgabehistory`
  ADD PRIMARY KEY (`rueckgabeid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ausleihe`
--
ALTER TABLE `ausleihe`
  MODIFY `ausleihid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT für Tabelle `rueckgabehistory`
--
ALTER TABLE `rueckgabehistory`
  MODIFY `rueckgabeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ausleihe`
--
ALTER TABLE `ausleihe`
  ADD CONSTRAINT `fk_inventarid` FOREIGN KEY (`inventarid`) REFERENCES `inventar` (`inventarid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rehanr` FOREIGN KEY (`rehanr`) REFERENCES `rehabilitandinnen` (`rehanr`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
