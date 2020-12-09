-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Dez 2020 um 20:12
-- Server-Version: 10.4.17-MariaDB
-- PHP-Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `inf19b_aaht_flight`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account`
--

CREATE TABLE `account` (
  `username` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` int(8) NOT NULL,
  `first_name` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `postal_code` int(5) UNSIGNED ZEROFILL NOT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `street` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `street_number` varchar(5) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `account`
--

INSERT INTO `account` (`username`, `password`, `email`, `role`, `first_name`, `last_name`, `postal_code`, `city`, `street`, `street_number`) VALUES
('autologinTest', '50c1b89e444754767f8b35c6c152fa9c7e8dc2c976b021324fd6977ec118c3e44619848ba1e0494095ca756975affe537b61484b0970be6ed7b3901e58f90033', 'andreas.koehler1996@gmail.com', 3, 'Andreas', 'Köhler', 74078, 'Heilbronn', 'Rilkestraße', '27'),
('I💙Germany', '2bbe0c48b91a7d1b8a6753a8b9cbe1db16b84379f3f91fe115621284df7a48f1cd71e9beb90ea614c7bd924250aa9e446a866725e685a65df5d139a5cd180dc9', 'i@germany.de', 2, 'I💙', 'Germany', 88888, 'Deutschland', 'Deutsche Straße', '88'),
('I💙MyBed', 'bdf4f3c1d3ebeb1e1098e62d6964b43a38a7b858d6eff552d260b5e6574cb7ba74759201ffc4aaf966cde948d01bfc5c6bf6d5655938eb0d13e9c1f9df5dba4e', 'ilove@mybed.de', 2, 'I💙', 'MyBed', 83777, 'Bettstadt', 'Bettstraße', '1'),
('testUser', '0f9160fb9a5a54bfbfe5dc14621f2bdd0addbc2cae091687b0dabb1b920f9007ee86def1ce474c5f5f4bee1ca667c1b48c94a445e24384988944bd87a8a29a5f', '96andy96@gmail.com', 2, 'Donald J.', 'Trump', 74078, 'Heilbronn', 'Rilkestraße', '27'),
('TomTom', '5101b6c7afea07cd49877fe6584a96a1f876190279eb97a9d9b5c69b8ab5922ae5e4af79bba96835fbb47a7181b964540f4bc4f993f69707ac272f8749328794', 'tom@tom.tom', 2, 'Tom', 'Tom', 74858, 'Tom', 'Tom', 'Tom');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `picture_path` varchar(96) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `airline`
--

INSERT INTO `airline` (`airline_id`, `name`, `picture_path`) VALUES
(1, 'Lufthansa', 'lufthansa.png'),
(2, 'Ryanair', 'ryanair.png'),
(3, 'EasyJet', 'easyjet.png'),
(4, 'American Airlines', 'american_airlines.jpg'),
(5, 'United Airlines', 'united_airlines.png'),
(6, 'Eurowings', 'eurowings.png'),
(7, 'Germanwings', 'germanwings.png'),
(8, 'TUIfly', 'tui_fly.png'),
(9, 'Condor', 'condor.png'),
(10, 'Air China', 'air_china.png'),
(11, 'Turkish Airlines', 'turkish_airlines.png'),
(12, 'Emirates', 'emirates.png'),
(13, 'Qantas Airways', 'qantas.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `airport`
--

CREATE TABLE `airport` (
  `icao_code` varchar(4) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `airport`
--

INSERT INTO `airport` (`icao_code`, `name`, `city`, `country`) VALUES
('EDAB', 'Bautzen', 'Bautzen', 'Germany'),
('EDDB', 'Berlin-Schönefeld', 'Berlin', 'Germany'),
('EDDC', 'Dresden', 'Dresden', 'Germany'),
('EDDF', 'Frankfurt am Main', 'Frankfurt am Main', 'Germany'),
('EDDH', 'Hamburg', 'Hamburg', 'Germany'),
('EDDK', 'Köln/Bonn', 'Köln', 'Germany'),
('EDDL', 'Düsseldorf', 'Düsseldorf', 'Germany'),
('EDDM', 'München', 'München', 'Germany'),
('EDDN', 'Nürnberg', 'Nürnberg', 'Germany'),
('EDDP', 'Leipzig/Halle', 'Leipzig/Halle', 'Germany'),
('EDDS', 'Stuttgart', 'Stuttgart', 'Germany'),
('EDDT', 'Berlin-Tegel', 'Berlin', 'Germany'),
('EDDV', 'Hannover', 'Hannover', 'Germany'),
('EGLL', 'Heathrow', 'London', 'Great Britain'),
('EHAM', 'Schiphol', 'Amsterdam', 'Netherlands'),
('KATL', 'Hartsfield–Jackson Atlanta International', 'Atlanta', 'USA'),
('KDEN', 'Denver International', 'Denver', 'USA'),
('KDFW', 'Dallas/Fort Worth International', 'Dallas', 'USA'),
('KJFK', 'John F. Kennedy International', 'New York City', 'USA'),
('KLAX', 'Los Angeles International', 'Los Angeles', 'USA'),
('KORD', 'O’Hare International', 'Chicago', 'USA'),
('LEPA', 'Son Sant Joan', 'Palma', 'Spain'),
('LFPG', 'Charles de Gaulle', 'Paris', 'France'),
('OMDB', 'Dubai International', 'Dubai', 'Vereinigte Arabische Emirate'),
('RJTT', 'Tokio-Haneda', 'Tokio', 'Japan'),
('RKSI', 'Incheon', 'Seoul', 'South Korea'),
('VHHH', 'Chek Lap Kok', 'Hongkong', 'China'),
('VIDP', 'Indira Gandhi International', 'New Delhi', 'India'),
('VTBS', 'Suvarnabhumi International', 'Bankok', 'Thailand'),
('WSSS', 'Singapore Changi', 'Singapur', 'Singapur'),
('ZBAA', 'Beijing Shoudu Guoji Jichang', 'Peking', 'China'),
('ZGGG', 'Guangzhou Baiyun International', 'Guangzhou', 'China'),
('ZSPD', 'Shanghai Pudong International', 'Shanghai', 'China');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) UNSIGNED NOT NULL,
  `airline_id` int(11) UNSIGNED NOT NULL,
  `departure_airport_code` varchar(4) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `destination_airport_code` varchar(4) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `plane_id` int(11) UNSIGNED NOT NULL,
  `departure_time` time NOT NULL,
  `departure_date` date NOT NULL,
  `passenger_seats` int(5) UNSIGNED NOT NULL,
  `booked_seats` int(5) UNSIGNED NOT NULL,
  `price` decimal(8,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `flight`
--

INSERT INTO `flight` (`flight_id`, `airline_id`, `departure_airport_code`, `destination_airport_code`, `plane_id`, `departure_time`, `departure_date`, `passenger_seats`, `booked_seats`, `price`) VALUES
(1, 10, 'EDDM', 'VHHH', 13, '18:39:00', '2021-07-19', 467, 200, '2000.00'),
(2, 12, 'EDDH', 'RJTT', 2, '17:00:00', '2021-03-23', 180, 174, '2000.00'),
(3, 1, 'EDDC', 'EDDF', 14, '18:00:00', '2021-02-18', 70, 65, '200.00'),
(4, 7, 'EDDF', 'KATL', 9, '18:01:00', '2021-03-23', 140, 30, '1500.00'),
(5, 8, 'EDDC', 'EGLL', 9, '23:09:00', '2021-03-23', 140, 130, '400.00'),
(6, 2, 'EGLL', 'EHAM', 14, '08:09:00', '2021-05-12', 70, 60, '150.00'),
(7, 13, 'EDDF', 'KJFK', 12, '04:18:00', '2021-02-22', 400, 170, '2000.00'),
(8, 11, 'EDDB', 'OMDB', 11, '07:18:00', '2021-04-21', 360, 200, '2000.00');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `flightview`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `flightview` (
`flight_id` int(11) unsigned
,`airline_id` int(11) unsigned
,`airline_name` varchar(30)
,`airline_picture` varchar(96)
,`departure_airport_code` varchar(4)
,`dep_city` varchar(30)
,`dep_name` varchar(40)
,`dep_country` varchar(30)
,`destination_airport_code` varchar(4)
,`dest_city` varchar(30)
,`dest_name` varchar(40)
,`dest_country` varchar(30)
,`plane_id` int(11) unsigned
,`pm_name` varchar(40)
,`model` varchar(30)
,`departure_time` time
,`departure_date` date
,`passenger_seats` int(5) unsigned
,`booked_seats` int(5) unsigned
,`price` decimal(8,2) unsigned
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payment_option`
--

CREATE TABLE `payment_option` (
  `payment_id` int(11) UNSIGNED NOT NULL,
  `iban` varchar(34) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `uname` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `payment_option`
--

INSERT INTO `payment_option` (`payment_id`, `iban`, `uname`) VALUES
(2, 'US8745319937562', 'testUser'),
(3, 'DE7329423843298', 'autologinTest'),
(6, 'DE85790900000001234567', 'I💙Germany'),
(7, 'DE85790900000001234567', 'I💙MyBed'),
(8, 'DE94500105179535275528', 'TomTom');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane`
--

CREATE TABLE `plane` (
  `plane_id` int(11) UNSIGNED NOT NULL,
  `manufacturer_id` int(4) UNSIGNED NOT NULL,
  `model` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `travel_speed` int(16) UNSIGNED NOT NULL,
  `travel_height` int(16) UNSIGNED NOT NULL,
  `travel_range` int(16) UNSIGNED NOT NULL,
  `passenger_seats_factory` int(5) UNSIGNED NOT NULL,
  `picture_path` varchar(96) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `plane`
--

INSERT INTO `plane` (`plane_id`, `manufacturer_id`, `model`, `travel_speed`, `travel_height`, `travel_range`, `passenger_seats_factory`, `picture_path`) VALUES
(1, 3, 'A380-800', 940, 13100, 15200, 853, 'a380-800.jpg'),
(2, 3, 'A320neo', 833, 12000, 6300, 194, 'a320neo.jpg'),
(3, 3, 'A319neo', 833, 12000, 6950, 160, 'a319neo.jpg'),
(4, 3, 'A321neo', 833, 12000, 7400, 240, 'a321neo.jpg'),
(5, 3, 'A318', 829, 12500, 5741, 132, 'a318.jpg'),
(6, 3, 'A319', 829, 12500, 6945, 156, 'a319.jpg'),
(7, 3, 'A320', 829, 12500, 6112, 186, 'a320.jpg'),
(8, 3, 'A321', 829, 12500, 5926, 236, 'a321.jpg'),
(9, 4, '737-300', 800, 11000, 4400, 149, '737-300.jpg'),
(10, 4, '737-800', 830, 12497, 6650, 189, '737-800.jpg'),
(11, 4, '777-8', 800, 11000, 16170, 384, '777-8.jpg'),
(12, 4, '747-400', 933, 13000, 14200, 416, '747-400.jpg'),
(13, 4, '747-8', 933, 13000, 14320, 467, '747-8.jpg'),
(14, 5, 'CRJ700', 870, 12496, 2022, 70, 'crj700.jpg'),
(15, 5, 'CRJ900', 882, 12496, 1737, 90, 'crj900.jpg'),
(17, 5, 'CRJ1000', 870, 12496, 2639, 104, 'crj1000.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_manufacturer`
--

CREATE TABLE `plane_manufacturer` (
  `manufacturer_id` int(4) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `picture_path` varchar(96) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `plane_manufacturer`
--

INSERT INTO `plane_manufacturer` (`manufacturer_id`, `name`, `picture_path`) VALUES
(3, 'Airbus', 'airbus.jpg'),
(4, 'Boeing', 'boeing.jpg'),
(5, 'Bombardier', 'bombardier.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE `role` (
  `id` int(8) NOT NULL,
  `description` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
(3, 'Administrator'),
(2, 'Kunde'),
(1, 'Mitarbeiter');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `userdata`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `userdata` (
`username` varchar(20)
,`password` varchar(128)
,`email` varchar(40)
,`role` varchar(40)
,`roleid` int(8)
,`first_name` varchar(20)
,`last_name` varchar(20)
,`postal_code` int(5) unsigned zerofill
,`city` varchar(40)
,`street` varchar(40)
,`street_number` varchar(5)
,`iban` varchar(34)
);

-- --------------------------------------------------------

--
-- Struktur des Views `flightview`
--
DROP TABLE IF EXISTS `flightview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `flightview`  AS SELECT `f`.`flight_id` AS `flight_id`, `f`.`airline_id` AS `airline_id`, `al`.`name` AS `airline_name`, `al`.`picture_path` AS `airline_picture`, `f`.`departure_airport_code` AS `departure_airport_code`, `a1`.`city` AS `dep_city`, `a1`.`name` AS `dep_name`, `a1`.`country` AS `dep_country`, `f`.`destination_airport_code` AS `destination_airport_code`, `a2`.`city` AS `dest_city`, `a2`.`name` AS `dest_name`, `a2`.`country` AS `dest_country`, `f`.`plane_id` AS `plane_id`, `pm`.`name` AS `pm_name`, `p`.`model` AS `model`, `f`.`departure_time` AS `departure_time`, `f`.`departure_date` AS `departure_date`, `f`.`passenger_seats` AS `passenger_seats`, `f`.`booked_seats` AS `booked_seats`, `f`.`price` AS `price` FROM (((((`flight` `f` join `airline` `al`) join `airport` `a1`) join `airport` `a2`) join `plane` `p`) join `plane_manufacturer` `pm`) WHERE `f`.`airline_id` = `al`.`airline_id` AND `f`.`departure_airport_code` = `a1`.`icao_code` AND `f`.`destination_airport_code` = `a2`.`icao_code` AND `p`.`plane_id` = `f`.`plane_id` AND `p`.`manufacturer_id` = `pm`.`manufacturer_id` ;

-- --------------------------------------------------------

--
-- Struktur des Views `userdata`
--
DROP TABLE IF EXISTS `userdata`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userdata`  AS SELECT `account`.`username` AS `username`, `account`.`password` AS `password`, `account`.`email` AS `email`, `role`.`description` AS `role`, `role`.`id` AS `roleid`, `account`.`first_name` AS `first_name`, `account`.`last_name` AS `last_name`, `account`.`postal_code` AS `postal_code`, `account`.`city` AS `city`, `account`.`street` AS `street`, `account`.`street_number` AS `street_number`, `payment_option`.`iban` AS `iban` FROM ((`account` join `role` on(`account`.`role` = `role`.`id`)) join `payment_option` on(`account`.`username` = `payment_option`.`uname`)) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_c` (`role`);

--
-- Indizes für die Tabelle `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`icao_code`) KEY_BLOCK_SIZE=4,
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `plane_id_c` (`plane_id`),
  ADD KEY `airline_id_c` (`airline_id`),
  ADD KEY `departure_airport_code_c` (`departure_airport_code`),
  ADD KEY `destination_airport_code_c` (`destination_airport_code`);

--
-- Indizes für die Tabelle `payment_option`
--
ALTER TABLE `payment_option`
  ADD PRIMARY KEY (`payment_id`) KEY_BLOCK_SIZE=11,
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indizes für die Tabelle `plane`
--
ALTER TABLE `plane`
  ADD PRIMARY KEY (`plane_id`) KEY_BLOCK_SIZE=8,
  ADD UNIQUE KEY `model` (`model`),
  ADD KEY `manufacturer_id_c` (`manufacturer_id`);

--
-- Indizes für die Tabelle `plane_manufacturer`
--
ALTER TABLE `plane_manufacturer`
  ADD PRIMARY KEY (`manufacturer_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`description`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `payment_option`
--
ALTER TABLE `payment_option`
  MODIFY `payment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `plane`
--
ALTER TABLE `plane`
  MODIFY `plane_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `plane_manufacturer`
--
ALTER TABLE `plane_manufacturer`
  MODIFY `manufacturer_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `role`
--
ALTER TABLE `role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `role_c` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

--
-- Constraints der Tabelle `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `airline_id_c` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`),
  ADD CONSTRAINT `departure_airport_code_c` FOREIGN KEY (`departure_airport_code`) REFERENCES `airport` (`icao_code`),
  ADD CONSTRAINT `destination_airport_code_c` FOREIGN KEY (`destination_airport_code`) REFERENCES `airport` (`icao_code`),
  ADD CONSTRAINT `plane_id_c` FOREIGN KEY (`plane_id`) REFERENCES `plane` (`plane_id`);

--
-- Constraints der Tabelle `payment_option`
--
ALTER TABLE `payment_option`
  ADD CONSTRAINT `uname_c` FOREIGN KEY (`uname`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `plane`
--
ALTER TABLE `plane`
  ADD CONSTRAINT `manufacturer_id_c` FOREIGN KEY (`manufacturer_id`) REFERENCES `plane_manufacturer` (`manufacturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
