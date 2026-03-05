-- =========================================================
-- GECOD Initiative Database Schema — Updated
-- Aligned with current UI design (March 2026)
-- =========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

-- Database: `gecodini_gecoddatabase`

-- --------------------------------------------------------
-- Table: gecodevents
-- Change: eventInfo longblob → LONGTEXT
--         eventLocation blob → VARCHAR(255)
--         eventTitle varchar(100) → varchar(255)
-- --------------------------------------------------------
CREATE TABLE `gecodevents` (
  `recordid`       int(11)      NOT NULL,
  `eventTitle`     varchar(255) NOT NULL,
  `eventInfo`      LONGTEXT     NOT NULL,
  `eventDate`      date         NOT NULL,
  `eventTimeStart` time         NOT NULL,
  `eventTimeEnd`   time         NOT NULL,
  `eventLocation`  varchar(255) NOT NULL,
  `eventImageLogo` varchar(255) NOT NULL,
  `uploadDate`     datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: gecodorphans
-- Change: orphanNames varchar(40) → varchar(100)
--         orphanInfo blob → TEXT
-- --------------------------------------------------------
CREATE TABLE `gecodorphans` (
  `recordid`      int(11)      NOT NULL,
  `orphanid`      varchar(40)  NOT NULL,
  `orphanNames`   varchar(100) NOT NULL,
  `orphanBirthday` date        NOT NULL,
  `orphanInfo`    TEXT         NOT NULL,
  `orphanImage`   varchar(255) NOT NULL,
  `orphanGender`  varchar(10)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: gecodpartners
-- No changes needed
-- --------------------------------------------------------
CREATE TABLE `gecodpartners` (
  `recordid`     int(11)      NOT NULL,
  `partnernames` varchar(255) NOT NULL,
  `partnerlogo`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: gecodroadmap
-- Change: content blob → LONGTEXT
-- --------------------------------------------------------
CREATE TABLE `gecodroadmap` (
  `recordid`   int(11)      NOT NULL,
  `Title`      varchar(255) NOT NULL,
  `content`    LONGTEXT     NOT NULL,
  `image`      varchar(255) NOT NULL,
  `uploadDate` datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: gecodusers
-- Change: gecodUpassword stays varchar(255) — correct for bcrypt
--         gecodUimage varchar(255) — kept (admin profile)
-- --------------------------------------------------------
CREATE TABLE `gecodusers` (
  `recordid`       int(11)      NOT NULL,
  `gecodUname`     varchar(255) NOT NULL,
  `gecodUpassword` varchar(255) NOT NULL,
  `gecodUimage`    varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: jobcareer
-- Change: JobDescription/qualifications/experience/contacts blob → LONGTEXT
--         deadlineDate blob → DATE (critical fix)
--         workingHours already added as varchar(100)
-- --------------------------------------------------------
CREATE TABLE `jobcareer` (
  `recordid`       int(11)      NOT NULL,
  `job_title`      varchar(255) NOT NULL,
  `JobDescription` LONGTEXT     NOT NULL,
  `position`       varchar(255) NOT NULL,
  `location`       varchar(255) NOT NULL,
  `qualifications` LONGTEXT     NOT NULL,
  `experience`     LONGTEXT     NOT NULL,
  `contacts`       LONGTEXT     NOT NULL,
  `imgBanner`      varchar(255) NOT NULL,
  `deadlineDate`   date         NOT NULL,
  `hiringType`     varchar(50)  NOT NULL,
  `workingHours`   varchar(100) NOT NULL DEFAULT '',
  `uploadDate`     datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: teammembers
-- Change: image varchar(30) → varchar(255)
--         (generated filenames e.g. "ABC123 1741234567.jpeg" exceed 30 chars)
-- --------------------------------------------------------
CREATE TABLE `teammembers` (
  `recordid` int(11)      NOT NULL,
  `Names`    varchar(100) NOT NULL,
  `Title`    varchar(100) NOT NULL,
  `Twitter`  varchar(255) NOT NULL DEFAULT '',
  `Facebook` varchar(255) NOT NULL DEFAULT '',
  `Whatsapp` varchar(255) NOT NULL DEFAULT '',
  `image`    varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: payment  (legacy PayPal IPN table)
-- Change: MyISAM → InnoDB, latin1 → utf8mb4
-- --------------------------------------------------------
CREATE TABLE `payment` (
  `id`               int(11)       NOT NULL,
  `item_number`      varchar(255)  NOT NULL,
  `item_name`        varchar(255)  NOT NULL,
  `payment_status`   varchar(50)   NOT NULL,
  `payment_amount`   double(10,2)  NOT NULL,
  `payment_currency` varchar(10)   NOT NULL,
  `txn_id`           varchar(255)  NOT NULL,
  `create_at`        timestamp     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: paypaldonations  (general donation records)
-- Change: added donor_name for checkout form data
-- --------------------------------------------------------
CREATE TABLE `paypaldonations` (
  `recordid`       int(11)      NOT NULL,
  `payment_id`     varchar(255) NOT NULL,
  `payer_id`       varchar(255) NOT NULL,
  `payer_email`    varchar(255) NOT NULL,
  `donor_name`     varchar(100) NOT NULL DEFAULT '',
  `amount`         float(10,2)  NOT NULL,
  `currency`       varchar(10)  NOT NULL DEFAULT 'USD',
  `payment_status` varchar(50)  NOT NULL,
  `paymentDate`    datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: paypalsponsors  (child sponsorship records)
-- Change: added donor_name, child_name, paymentDate
--         These are collected by vieworphandetails.php modal
--         and confirmed by PayPal callback
-- --------------------------------------------------------
CREATE TABLE `paypalsponsors` (
  `recordid`        int(11)      NOT NULL,
  `orphanid`        varchar(40)  NOT NULL,
  `child_name`      varchar(100) NOT NULL DEFAULT '',
  `donor_email`     varchar(255) NOT NULL,
  `donor_name`      varchar(100) NOT NULL DEFAULT '',
  `payment_id`      varchar(255) NOT NULL,
  `amountSponsored` float(10,2)  NOT NULL,
  `currency`        varchar(10)  NOT NULL DEFAULT 'USD',
  `payment_status`  varchar(50)  NOT NULL,
  `paymentDate`     datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: newsletter_subscribers  (NEW)
-- Newsletter emails from contact page currently only get
-- emailed to info@gecodinitiative.org — now also stored here
-- --------------------------------------------------------
CREATE TABLE `newsletter_subscribers` (
  `id`            int(11)      NOT NULL,
  `email`         varchar(255) NOT NULL,
  `subscribed_at` datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================================
-- Indexes
-- ========================================================
ALTER TABLE `gecodevents`           ADD PRIMARY KEY (`recordid`);
ALTER TABLE `gecodorphans`          ADD PRIMARY KEY (`recordid`), ADD UNIQUE KEY `orphanid` (`orphanid`);
ALTER TABLE `gecodpartners`         ADD PRIMARY KEY (`recordid`);
ALTER TABLE `gecodroadmap`          ADD PRIMARY KEY (`recordid`);
ALTER TABLE `gecodusers`            ADD PRIMARY KEY (`recordid`), ADD UNIQUE KEY `gecodUname` (`gecodUname`);
ALTER TABLE `jobcareer`             ADD PRIMARY KEY (`recordid`);
ALTER TABLE `teammembers`           ADD PRIMARY KEY (`recordid`);
ALTER TABLE `payment`               ADD PRIMARY KEY (`id`);
ALTER TABLE `paypaldonations`       ADD PRIMARY KEY (`recordid`);
ALTER TABLE `paypalsponsors`        ADD PRIMARY KEY (`recordid`), ADD KEY `idx_orphanid` (`orphanid`);
ALTER TABLE `newsletter_subscribers` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

-- ========================================================
-- AUTO_INCREMENT
-- ========================================================
ALTER TABLE `gecodevents`            MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gecodorphans`           MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gecodpartners`          MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gecodroadmap`           MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gecodusers`             MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `jobcareer`              MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teammembers`            MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `payment`                MODIFY `id`       int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paypaldonations`        MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paypalsponsors`         MODIFY `recordid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `newsletter_subscribers` MODIFY `id`       int(11) NOT NULL AUTO_INCREMENT;

COMMIT;
