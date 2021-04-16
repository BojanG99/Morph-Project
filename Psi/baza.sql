-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: morphe_schema
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

CREATE DATABASE morphe_schema;
USE morphe_schema;

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `idKor` int NOT NULL,
  PRIMARY KEY (`idKor`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caskanje`
--

DROP TABLE IF EXISTS `caskanje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caskanje` (
  `idKli` int NOT NULL,
  `idMen` int NOT NULL,
  PRIMARY KEY (`idKli`,`idMen`),
  KEY `idMen` (`idMen`),
  CONSTRAINT `caskanje_ibfk_1` FOREIGN KEY (`idKli`) REFERENCES `klijent` (`idKor`),
  CONSTRAINT `caskanje_ibfk_2` FOREIGN KEY (`idMen`) REFERENCES `menadzer` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caskanje`
--

LOCK TABLES `caskanje` WRITE;
/*!40000 ALTER TABLE `caskanje` DISABLE KEYS */;
/*!40000 ALTER TABLE `caskanje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fajl_za_zadatak`
--

DROP TABLE IF EXISTS `fajl_za_zadatak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fajl_za_zadatak` (
  `idFaj` int NOT NULL AUTO_INCREMENT,
  `idZad` int NOT NULL,
  `ime` varchar(256) NOT NULL,
  PRIMARY KEY (`idFaj`),
  KEY `idZad` (`idZad`),
  CONSTRAINT `fajl_za_zadatak_ibfk_1` FOREIGN KEY (`idZad`) REFERENCES `zadatak` (`idZad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fajl_za_zadatak`
--

LOCK TABLES `fajl_za_zadatak` WRITE;
/*!40000 ALTER TABLE `fajl_za_zadatak` DISABLE KEYS */;
/*!40000 ALTER TABLE `fajl_za_zadatak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `istorija_pretrazivanje`
--

DROP TABLE IF EXISTS `istorija_pretrazivanje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `istorija_pretrazivanje` (
  `idPre` int NOT NULL AUTO_INCREMENT,
  `idKor` int NOT NULL,
  `tekst` varchar(256) NOT NULL,
  `broj_ponavljanja` int NOT NULL,
  PRIMARY KEY (`idPre`),
  KEY `idKor` (`idKor`),
  CONSTRAINT `istorija_pretrazivanje_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `istorija_pretrazivanje`
--

LOCK TABLES `istorija_pretrazivanje` WRITE;
/*!40000 ALTER TABLE `istorija_pretrazivanje` DISABLE KEYS */;
/*!40000 ALTER TABLE `istorija_pretrazivanje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klijent`
--

DROP TABLE IF EXISTS `klijent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `klijent` (
  `idKor` int NOT NULL,
  PRIMARY KEY (`idKor`),
  CONSTRAINT `klijent_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klijent`
--

LOCK TABLES `klijent` WRITE;
/*!40000 ALTER TABLE `klijent` DISABLE KEYS */;
/*!40000 ALTER TABLE `klijent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konkurs`
--

DROP TABLE IF EXISTS `konkurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konkurs` (
  `idKon` int NOT NULL AUTO_INCREMENT,
  `idJez` int NOT NULL,
  `idMen` int NOT NULL,
  `opis` varchar(256) NOT NULL,
  `vreme_pocetka` datetime NOT NULL,
  `vreme_kraja` datetime NOT NULL,
  `status_konkursa` enum('Otvoren','Zatvoren') NOT NULL,
  PRIMARY KEY (`idKon`),
  KEY `idJez` (`idJez`),
  KEY `idMen` (`idMen`),
  CONSTRAINT `konkurs_ibfk_1` FOREIGN KEY (`idJez`) REFERENCES `programski_jezik` (`idPro`),
  CONSTRAINT `konkurs_ibfk_2` FOREIGN KEY (`idMen`) REFERENCES `menadzer` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konkurs`
--

LOCK TABLES `konkurs` WRITE;
/*!40000 ALTER TABLE `konkurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `konkurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `korisnik` (
  `idKor` int NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` varchar(256) NOT NULL,
  `lozinka` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `broj_telefona` varchar(256) NOT NULL,
  `slika_URL` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisniknacekanju`
--

DROP TABLE IF EXISTS `korisniknacekanju`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `korisniknacekanju` (
  `idKor` int NOT NULL,
  PRIMARY KEY (`idKor`),
  CONSTRAINT `korisniknacekanju_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisniknacekanju`
--

LOCK TABLES `korisniknacekanju` WRITE;
/*!40000 ALTER TABLE `korisniknacekanju` DISABLE KEYS */;
/*!40000 ALTER TABLE `korisniknacekanju` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menadzer`
--

DROP TABLE IF EXISTS `menadzer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menadzer` (
  `idKor` int NOT NULL,
  `prosecna_ocena` float NOT NULL,
  `broj_glasova` int NOT NULL,
  `status_menadzera` enum('Angazovan','Neangazovan') NOT NULL,
  PRIMARY KEY (`idKor`),
  CONSTRAINT `menadzer_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menadzer`
--

LOCK TABLES `menadzer` WRITE;
/*!40000 ALTER TABLE `menadzer` DISABLE KEYS */;
/*!40000 ALTER TABLE `menadzer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poruka`
--

DROP TABLE IF EXISTS `poruka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poruka` (
  `idPor` int NOT NULL AUTO_INCREMENT,
  `idKli` int NOT NULL,
  `idMen` int NOT NULL,
  `tekst` varchar(256) NOT NULL,
  `status_poruke` enum('Poslata','Primljena') NOT NULL,
  `poslata_od` enum('Klijenta','Menadzera') NOT NULL,
  `datum_vreme_slanja` datetime NOT NULL,
  PRIMARY KEY (`idPor`),
  KEY `idKli` (`idKli`,`idMen`),
  CONSTRAINT `poruka_ibfk_1` FOREIGN KEY (`idKli`, `idMen`) REFERENCES `caskanje` (`idKli`, `idMen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poruka`
--

LOCK TABLES `poruka` WRITE;
/*!40000 ALTER TABLE `poruka` DISABLE KEYS */;
/*!40000 ALTER TABLE `poruka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pozvan_na_konkurs`
--

DROP TABLE IF EXISTS `pozvan_na_konkurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pozvan_na_konkurs` (
  `idKon` int NOT NULL,
  `idPro` int NOT NULL,
  `status_prijave` enum('Otvoren','Prihvacen','Odbijen') NOT NULL,
  PRIMARY KEY (`idKon`,`idPro`),
  KEY `idPro` (`idPro`),
  CONSTRAINT `pozvan_na_konkurs_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`),
  CONSTRAINT `pozvan_na_konkurs_ibfk_2` FOREIGN KEY (`idPro`) REFERENCES `programer` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pozvan_na_konkurs`
--

LOCK TABLES `pozvan_na_konkurs` WRITE;
/*!40000 ALTER TABLE `pozvan_na_konkurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pozvan_na_konkurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijavio_se_na_konkurs`
--

DROP TABLE IF EXISTS `prijavio_se_na_konkurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijavio_se_na_konkurs` (
  `idKon` int NOT NULL,
  `idPro` int NOT NULL,
  `status_prijave` enum('Otvoren','Prihvacen','Odbijen') NOT NULL,
  PRIMARY KEY (`idKon`,`idPro`),
  KEY `idPro` (`idPro`),
  CONSTRAINT `prijavio_se_na_konkurs_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`),
  CONSTRAINT `prijavio_se_na_konkurs_ibfk_2` FOREIGN KEY (`idPro`) REFERENCES `programer` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijavio_se_na_konkurs`
--

LOCK TABLES `prijavio_se_na_konkurs` WRITE;
/*!40000 ALTER TABLE `prijavio_se_na_konkurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `prijavio_se_na_konkurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programer`
--

DROP TABLE IF EXISTS `programer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programer` (
  `idKor` int NOT NULL,
  `prosecna_ocena` float NOT NULL,
  `broj_glasova` int NOT NULL,
  `status_menadzera` enum('Angazovan','Neangazovan') NOT NULL,
  PRIMARY KEY (`idKor`),
  CONSTRAINT `programer_ibfk_1` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programer`
--

LOCK TABLES `programer` WRITE;
/*!40000 ALTER TABLE `programer` DISABLE KEYS */;
/*!40000 ALTER TABLE `programer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programer_radi_na`
--

DROP TABLE IF EXISTS `programer_radi_na`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programer_radi_na` (
  `idProgramera` int NOT NULL,
  `idProjekta` int NOT NULL,
  PRIMARY KEY (`idProgramera`,`idProjekta`),
  KEY `idProjekta` (`idProjekta`),
  CONSTRAINT `programer_radi_na_ibfk_1` FOREIGN KEY (`idProgramera`) REFERENCES `programer` (`idKor`),
  CONSTRAINT `programer_radi_na_ibfk_2` FOREIGN KEY (`idProjekta`) REFERENCES `projekat` (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programer_radi_na`
--

LOCK TABLES `programer_radi_na` WRITE;
/*!40000 ALTER TABLE `programer_radi_na` DISABLE KEYS */;
/*!40000 ALTER TABLE `programer_radi_na` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programski_jezik`
--

DROP TABLE IF EXISTS `programski_jezik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programski_jezik` (
  `idPro` int NOT NULL AUTO_INCREMENT,
  `naziv` varchar(256) NOT NULL,
  PRIMARY KEY (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programski_jezik`
--

LOCK TABLES `programski_jezik` WRITE;
/*!40000 ALTER TABLE `programski_jezik` DISABLE KEYS */;
/*!40000 ALTER TABLE `programski_jezik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projekat`
--

DROP TABLE IF EXISTS `projekat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projekat` (
  `idPro` int NOT NULL AUTO_INCREMENT,
  `idKon` int NOT NULL,
  `putanja_u_fajl_sistemu` varchar(256) NOT NULL,
  PRIMARY KEY (`idPro`),
  KEY `idKon` (`idKon`),
  CONSTRAINT `projekat_ibfk_1` FOREIGN KEY (`idKon`) REFERENCES `konkurs` (`idKon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projekat`
--

LOCK TABLES `projekat` WRITE;
/*!40000 ALTER TABLE `projekat` DISABLE KEYS */;
/*!40000 ALTER TABLE `projekat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vreme_na_projektu`
--

DROP TABLE IF EXISTS `vreme_na_projektu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vreme_na_projektu` (
  `idVre` int NOT NULL AUTO_INCREMENT,
  `idProjekta` int NOT NULL,
  `idProgramera` int NOT NULL,
  `vreme_pocetka` datetime NOT NULL,
  `vreme_kraja` datetime NOT NULL,
  PRIMARY KEY (`idVre`),
  KEY `idProjekta` (`idProjekta`,`idProgramera`),
  CONSTRAINT `vreme_na_projektu_ibfk_1` FOREIGN KEY (`idProjekta`, `idProgramera`) REFERENCES `programer_radi_na` (`idProjekta`, `idProgramera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vreme_na_projektu`
--

LOCK TABLES `vreme_na_projektu` WRITE;
/*!40000 ALTER TABLE `vreme_na_projektu` DISABLE KEYS */;
/*!40000 ALTER TABLE `vreme_na_projektu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zadatak`
--

DROP TABLE IF EXISTS `zadatak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zadatak` (
  `idZad` int NOT NULL AUTO_INCREMENT,
  `idProjekta` int NOT NULL,
  `idProgramera` int NOT NULL,
  `opis` varchar(256) NOT NULL,
  `faza` enum('Implementacije','Testiranja','Gotovo') NOT NULL,
  PRIMARY KEY (`idZad`),
  KEY `idProjekta` (`idProjekta`),
  KEY `idProgramera` (`idProgramera`),
  CONSTRAINT `zadatak_ibfk_1` FOREIGN KEY (`idProjekta`) REFERENCES `projekat` (`idPro`),
  CONSTRAINT `zadatak_ibfk_2` FOREIGN KEY (`idProgramera`) REFERENCES `programer` (`idKor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zadatak`
--

LOCK TABLES `zadatak` WRITE;
/*!40000 ALTER TABLE `zadatak` DISABLE KEYS */;
/*!40000 ALTER TABLE `zadatak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-17  1:14:18
