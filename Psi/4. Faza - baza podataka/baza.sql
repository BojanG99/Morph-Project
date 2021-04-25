-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2021 at 05:40 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `morphe_schema`
--
CREATE DATABASE IF NOT EXISTS `morphe_schema` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `morphe_schema`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idKor` int(11) NOT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idKor`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `caskanje`
--

DROP TABLE IF EXISTS `caskanje`;
CREATE TABLE IF NOT EXISTS `caskanje` (
  `idKli` int(11) NOT NULL,
  `idMen` int(11) NOT NULL,
  PRIMARY KEY (`idKli`,`idMen`),
  KEY `idMen` (`idMen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fajl_za_zadatak`
--

DROP TABLE IF EXISTS `fajl_za_zadatak`;
CREATE TABLE IF NOT EXISTS `fajl_za_zadatak` (
  `idFaj` int(11) NOT NULL AUTO_INCREMENT,
  `idZad` int(11) NOT NULL,
  `ime` varchar(256) NOT NULL,
  PRIMARY KEY (`idFaj`),
  KEY `idZad` (`idZad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `istorija_pretrazivanje`
--

DROP TABLE IF EXISTS `istorija_pretrazivanje`;
CREATE TABLE IF NOT EXISTS `istorija_pretrazivanje` (
  `idPre` int(11) NOT NULL AUTO_INCREMENT,
  `idKor` int(11) NOT NULL,
  `tekst` varchar(256) NOT NULL,
  `broj_ponavljanja` int(11) NOT NULL,
  PRIMARY KEY (`idPre`),
  KEY `idKor` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `klijent`
--

DROP TABLE IF EXISTS `klijent`;
CREATE TABLE IF NOT EXISTS `klijent` (
  `idKor` int(11) NOT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `konkurs`
--

DROP TABLE IF EXISTS `konkurs`;
CREATE TABLE IF NOT EXISTS `konkurs` (
  `idKon` int(11) NOT NULL AUTO_INCREMENT,
  `idJez` int(11) NOT NULL,
  `idMen` int(11) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `vreme_pocetka` datetime NOT NULL,
  `vreme_kraja` datetime NOT NULL,
  `status_konkursa` enum('Otvoren','Zatvoren') NOT NULL,
  PRIMARY KEY (`idKon`),
  KEY `idJez` (`idJez`),
  KEY `idMen` (`idMen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `idKor` int(11) NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` varchar(256) NOT NULL,
  `lozinka` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `broj_telefona` varchar(256) NOT NULL,
  `slika_URL` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idKor`, `korisnicko_ime`, `lozinka`, `email`, `broj_telefona`, `slika_URL`) VALUES
(1, 'admin', 'admin', 'nesto@gmail.com', '060021231', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korisniknacekanju`
--

DROP TABLE IF EXISTS `korisniknacekanju`;
CREATE TABLE IF NOT EXISTS `korisniknacekanju` (
  `idKor` int(11) NOT NULL,
  `tip` enum('Programer','Klijent','Menadzer','') NOT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menadzer`
--

DROP TABLE IF EXISTS `menadzer`;
CREATE TABLE IF NOT EXISTS `menadzer` (
  `idKor` int(11) NOT NULL,
  `prosecna_ocena` float NOT NULL,
  `broj_glasova` int(11) NOT NULL,
  `status_menadzera` enum('Angazovan','Neangazovan') NOT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poruka`
--

DROP TABLE IF EXISTS `poruka`;
CREATE TABLE IF NOT EXISTS `poruka` (
  `idPor` int(11) NOT NULL AUTO_INCREMENT,
  `idKli` int(11) NOT NULL,
  `idMen` int(11) NOT NULL,
  `tekst` varchar(256) NOT NULL,
  `status_poruke` enum('Poslata','Primljena') NOT NULL,
  `poslata_od` enum('Klijenta','Menadzera') NOT NULL,
  `datum_vreme_slanja` datetime NOT NULL,
  PRIMARY KEY (`idPor`),
  KEY `idKli` (`idKli`,`idMen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pozvan_na_konkurs`
--

DROP TABLE IF EXISTS `pozvan_na_konkurs`;
CREATE TABLE IF NOT EXISTS `pozvan_na_konkurs` (
  `idKon` int(11) NOT NULL,
  `idPro` int(11) NOT NULL,
  `status_prijave` enum('Otvoren','Prihvacen','Odbijen') NOT NULL,
  PRIMARY KEY (`idKon`,`idPro`),
  KEY `idPro` (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prijavio_se_na_konkurs`
--

DROP TABLE IF EXISTS `prijavio_se_na_konkurs`;
CREATE TABLE IF NOT EXISTS `prijavio_se_na_konkurs` (
  `idKon` int(11) NOT NULL,
  `idPro` int(11) NOT NULL,
  `status_prijave` enum('Otvoren','Prihvacen','Odbijen') NOT NULL,
  PRIMARY KEY (`idKon`,`idPro`),
  KEY `idPro` (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programer`
--

DROP TABLE IF EXISTS `programer`;
CREATE TABLE IF NOT EXISTS `programer` (
  `idKor` int(11) NOT NULL,
  `prosecna_ocena` float NOT NULL,
  `broj_glasova` int(11) NOT NULL,
  `status_programera` enum('Angazovan','Neangazovan') NOT NULL,
  `cv_URL` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programer_radi_na`
--

DROP TABLE IF EXISTS `programer_radi_na`;
CREATE TABLE IF NOT EXISTS `programer_radi_na` (
  `idProgramera` int(11) NOT NULL,
  `idProjekta` int(11) NOT NULL,
  PRIMARY KEY (`idProgramera`,`idProjekta`),
  KEY `idProjekta` (`idProjekta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programski_jezik`
--

DROP TABLE IF EXISTS `programski_jezik`;
CREATE TABLE IF NOT EXISTS `programski_jezik` (
  `idPro` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(256) NOT NULL,
  PRIMARY KEY (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projekat`
--

DROP TABLE IF EXISTS `projekat`;
CREATE TABLE IF NOT EXISTS `projekat` (
  `idPro` int(11) NOT NULL AUTO_INCREMENT,
  `idKon` int(11) NOT NULL,
  `putanja_u_fajl_sistemu` varchar(256) NOT NULL,
  PRIMARY KEY (`idPro`),
  KEY `idKon` (`idKon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vreme_na_projektu`
--

DROP TABLE IF EXISTS `vreme_na_projektu`;
CREATE TABLE IF NOT EXISTS `vreme_na_projektu` (
  `idVre` int(11) NOT NULL AUTO_INCREMENT,
  `idProjekta` int(11) NOT NULL,
  `idProgramera` int(11) NOT NULL,
  `vreme_pocetka` datetime NOT NULL,
  `vreme_kraja` datetime NOT NULL,
  PRIMARY KEY (`idVre`),
  KEY `idProjekta` (`idProjekta`,`idProgramera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zadatak`
--

DROP TABLE IF EXISTS `zadatak`;
CREATE TABLE IF NOT EXISTS `zadatak` (
  `idZad` int(11) NOT NULL AUTO_INCREMENT,
  `idProjekta` int(11) NOT NULL,
  `idProgramera` int(11) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `faza` enum('Implementacije','Testiranja','Gotovo') NOT NULL,
  PRIMARY KEY (`idZad`),
  KEY `idProjekta` (`idProjekta`),
  KEY `idProgramera` (`idProgramera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `caskanje`
--
ALTER TABLE `caskanje`
  ADD CONSTRAINT `caskanje_ibfk_1` FOREIGN KEY (`idKli`) REFERENCES `klijent` (`idKor`),
  ADD CONSTRAINT `caskanje_ibfk_2` FOREIGN KEY (`idMen`) REFERENCES `menadzer` (`idKor`);

--
-- Constraints for table `fajl_za_zadatak`
--
ALTER TABLE `fajl_za_zadatak`
  ADD CONSTRAINT `fajl_za_zadatak_ibfk_1` FOREIGN KEY (`idZad`) REFERENCES `zadatak` (`idZad`);

--
-- Constraints for table `istorija_pretrazivanje`
--
ALTER TABLE `istorija_pretrazivanje`
  ADD CONSTRAINT `istorija_pretrazivanje_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `klijent`
--
ALTER TABLE `klijent`
  ADD CONSTRAINT `klijent_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `konkurs`
--
ALTER TABLE `konkurs`
  ADD CONSTRAINT `konkurs_ibfk_1` FOREIGN KEY (`idJez`) REFERENCES `programski_jezik` (`idPro`),
  ADD CONSTRAINT `konkurs_ibfk_2` FOREIGN KEY (`idMen`) REFERENCES `menadzer` (`idKor`);

--
-- Constraints for table `korisniknacekanju`
--
ALTER TABLE `korisniknacekanju`
  ADD CONSTRAINT `idKor` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `menadzer`
--
ALTER TABLE `menadzer`
  ADD CONSTRAINT `menadzer_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `poruka`
--
ALTER TABLE `poruka`
  ADD CONSTRAINT `poruka_ibfk_1` FOREIGN KEY (`idKli`,`idMen`) REFERENCES `caskanje` (`idKli`, `idMen`);

--
-- Constraints for table `pozvan_na_konkurs`
--
ALTER TABLE `pozvan_na_konkurs`
  ADD CONSTRAINT `pozvan_na_konkurs_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`),
  ADD CONSTRAINT `pozvan_na_konkurs_ibfk_2` FOREIGN KEY (`idPro`) REFERENCES `programer` (`idKor`);

--
-- Constraints for table `prijavio_se_na_konkurs`
--
ALTER TABLE `prijavio_se_na_konkurs`
  ADD CONSTRAINT `prijavio_se_na_konkurs_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`),
  ADD CONSTRAINT `prijavio_se_na_konkurs_ibfk_2` FOREIGN KEY (`idPro`) REFERENCES `programer` (`idKor`);

--
-- Constraints for table `programer`
--
ALTER TABLE `programer`
  ADD CONSTRAINT `programer_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`);

--
-- Constraints for table `programer_radi_na`
--
ALTER TABLE `programer_radi_na`
  ADD CONSTRAINT `programer_radi_na_ibfk_1` FOREIGN KEY (`idProgramera`) REFERENCES `programer` (`idKor`),
  ADD CONSTRAINT `programer_radi_na_ibfk_2` FOREIGN KEY (`idProjekta`) REFERENCES `projekat` (`idPro`);

--
-- Constraints for table `projekat`
--
ALTER TABLE `projekat`
  ADD CONSTRAINT `projekat_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`);

--
-- Constraints for table `vreme_na_projektu`
--
ALTER TABLE `vreme_na_projektu`
  ADD CONSTRAINT `vreme_na_projektu_ibfk_1` FOREIGN KEY (`idProjekta`,`idProgramera`) REFERENCES `programer_radi_na` (`idProjekta`, `idProgramera`);

--
-- Constraints for table `zadatak`
--
ALTER TABLE `zadatak`
  ADD CONSTRAINT `zadatak_ibfk_1` FOREIGN KEY (`idProjekta`) REFERENCES `projekat` (`idPro`),
  ADD CONSTRAINT `zadatak_ibfk_2` FOREIGN KEY (`idProgramera`) REFERENCES `programer` (`idKor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
