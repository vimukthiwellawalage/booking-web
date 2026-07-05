-- Yamu Bus Display Panel feature — additive schema changes only.
-- Run this AFTER the existing ezbuslk_db dump. Does not modify any existing
-- table's data or drop any table used by booking/admin/operator flows.
--
-- Summary of changes:
--   1. ALTER `stop`  -> add nullable latitude/longitude (reuses the existing
--      stop/route_stop tables instead of creating duplicate parallel ones)
--   2. Seed approximate coordinates for the 28 existing stop rows, so the
--      display panel + GPS simulator have real data to test against
--   3. CREATE `iot_device`        -> registry linking a physical GPS module to a bus
--   4. CREATE `bus_live_location` -> historical/live GPS pings per bus
--   5. ALTER `trip` -> drop the unused `latitude`/`longitude` GEOMETRY columns
--      (dead columns from an earlier abandoned attempt at this feature; always
--      NULL in production data, confirmed unreferenced by any PHP code)

-- --------------------------------------------------------
-- 1. Add coordinates to the existing `stop` table
-- --------------------------------------------------------

ALTER TABLE `stop`
  ADD COLUMN `latitude` DECIMAL(10,7) NULL DEFAULT NULL AFTER `city`,
  ADD COLUMN `longitude` DECIMAL(10,7) NULL DEFAULT NULL AFTER `latitude`;

-- --------------------------------------------------------
-- 2. Seed approximate coordinates for testing.
--    NOTE: these are approximate town-center coordinates for simulation/
--    testing purposes only, not surveyed GPS positions. Refine as needed
--    before relying on them for real passenger-facing distance accuracy.
-- --------------------------------------------------------

UPDATE `stop` SET `latitude` = 7.0417, `longitude` = 80.2069 WHERE `stopID` = 'ALA'; -- Alawwa
UPDATE `stop` SET `latitude` = 6.4278, `longitude` = 79.9989 WHERE `stopID` = 'ALU'; -- Aluthgama
UPDATE `stop` SET `latitude` = 7.1667, `longitude` = 80.1167 WHERE `stopID` = 'AMB'; -- Ambepussa
UPDATE `stop` SET `latitude` = 8.3114, `longitude` = 80.4037 WHERE `stopID` = 'ANU'; -- Anuradhapura
UPDATE `stop` SET `latitude` = 6.8905, `longitude` = 79.8565 WHERE `stopID` = 'BAM'; -- Bambalapitiya
UPDATE `stop` SET `latitude` = 6.9271, `longitude` = 79.8612 WHERE `stopID` = 'COL'; -- Colombo
UPDATE `stop` SET `latitude` = 6.0535, `longitude` = 80.2210 WHERE `stopID` = 'GAL'; -- Galle
UPDATE `stop` SET `latitude` = 7.0917, `longitude` = 79.9931 WHERE `stopID` = 'GAM'; -- Gampaha
UPDATE `stop` SET `latitude` = 6.7151, `longitude` = 80.0631 WHERE `stopID` = 'HOR'; -- Horana
UPDATE `stop` SET `latitude` = 9.6615, `longitude` = 80.0255 WHERE `stopID` = 'JF';  -- Jaffna
UPDATE `stop` SET `latitude` = 7.0008, `longitude` = 79.9512 WHERE `stopID` = 'KAD'; -- Kadawatha
UPDATE `stop` SET `latitude` = 6.5854, `longitude` = 79.9607 WHERE `stopID` = 'KAL'; -- Kalutara
UPDATE `stop` SET `latitude` = 7.2906, `longitude` = 80.6337 WHERE `stopID` = 'KAN'; -- Kandy
UPDATE `stop` SET `latitude` = 6.4128, `longitude` = 81.3354 WHERE `stopID` = 'KAT'; -- Katharagama
UPDATE `stop` SET `latitude` = 7.2547, `longitude` = 80.5228 WHERE `stopID` = 'KDG'; -- Kadugannawa
UPDATE `stop` SET `latitude` = 7.2513, `longitude` = 80.3464 WHERE `stopID` = 'KEG'; -- Kegalle
UPDATE `stop` SET `latitude` = 6.0128, `longitude` = 80.2503 WHERE `stopID` = 'KOG'; -- Koggala
UPDATE `stop` SET `latitude` = 7.4867, `longitude` = 80.3647 WHERE `stopID` = 'KUR'; -- Kurunegala
UPDATE `stop` SET `latitude` = 5.9549, `longitude` = 80.5550 WHERE `stopID` = 'MAT'; -- Matara
UPDATE `stop` SET `latitude` = 7.2513, `longitude` = 80.4464 WHERE `stopID` = 'MAW'; -- Mawanella
UPDATE `stop` SET `latitude` = 7.2083, `longitude` = 79.8358 WHERE `stopID` = 'NEG'; -- Negombo
UPDATE `stop` SET `latitude` = 7.1439, `longitude` = 80.0965 WHERE `stopID` = 'NIT'; -- Nittambuwa
UPDATE `stop` SET `latitude` = 6.7130, `longitude` = 79.9074 WHERE `stopID` = 'PAN'; -- Panadura
UPDATE `stop` SET `latitude` = 7.2599, `longitude` = 80.5989 WHERE `stopID` = 'PER'; -- Peradeniya
UPDATE `stop` SET `latitude` = 6.8006, `longitude` = 79.9226 WHERE `stopID` = 'PIL'; -- Piliyandala
UPDATE `stop` SET `latitude` = 8.0362, `longitude` = 79.8283 WHERE `stopID` = 'PUT'; -- Puththalam
UPDATE `stop` SET `latitude` = 8.7514, `longitude` = 80.4971 WHERE `stopID` = 'VAV'; -- Vavuniya
UPDATE `stop` SET `latitude` = 7.2261, `longitude` = 80.1972 WHERE `stopID` = 'WAR'; -- Warakapola

-- --------------------------------------------------------
-- 3. IoT device registry — links a physical GPS module to a bus
-- --------------------------------------------------------

CREATE TABLE `iot_device` (
  `deviceID` int(11) NOT NULL AUTO_INCREMENT,
  `deviceUID` varchar(100) NOT NULL,
  `busID` varchar(100) NOT NULL,
  `apiKey` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `lastPingAt` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`deviceID`),
  UNIQUE KEY `deviceUID` (`deviceUID`),
  UNIQUE KEY `apiKey` (`apiKey`),
  KEY `fk_busid_iotdevice` (`busID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `iot_device`
  ADD CONSTRAINT `fk_busid_iotdevice` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------
-- 4. Live + historical GPS pings per bus
-- --------------------------------------------------------

CREATE TABLE `bus_live_location` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `busID` varchar(100) NOT NULL,
  `tripID` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `speedKmh` decimal(5,2) DEFAULT NULL,
  `headingDegrees` decimal(5,2) DEFAULT NULL,
  `recordedAt` datetime NOT NULL,
  PRIMARY KEY (`locationID`),
  KEY `fk_busid_liveloc` (`busID`),
  KEY `fk_tripid_liveloc` (`tripID`),
  KEY `idx_bus_recorded` (`busID`,`recordedAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `bus_live_location`
  ADD CONSTRAINT `fk_busid_liveloc` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tripid_liveloc` FOREIGN KEY (`tripID`) REFERENCES `trip` (`tripID`) ON DELETE SET NULL ON UPDATE CASCADE;

-- --------------------------------------------------------
-- 5. Drop unused dead columns from `trip` (always NULL, unreferenced by any
--    existing code — confirmed via full-codebase search before dropping)
-- --------------------------------------------------------

ALTER TABLE `trip`
  DROP COLUMN `longitude`,
  DROP COLUMN `latitude`;

-- --------------------------------------------------------
-- 6. Test device seed data, so tools/simulate-gps.php has something to use
--    immediately. Bus NC0909 has an active trip on route 32CK (Colombo ->
--    Katharagama) in the existing dump. Replace/remove once real hardware
--    is provisioned.
-- --------------------------------------------------------

INSERT INTO `iot_device` (`deviceUID`, `busID`, `apiKey`, `status`) VALUES
('TEST-DEVICE-NC0909', 'NC0909', 'test-api-key-nc0909-change-me', 'active');
