-- ============================================================
-- GECOD Initiative — Database Migration Script
-- Safe: MODIFY COLUMN keeps existing data, ADD COLUMN IF NOT
-- EXISTS won't fail if already added (MariaDB 10.3+)
-- ============================================================

-- 1. Fix text/content columns: blob → proper TEXT types
ALTER TABLE `gecodorphans`
  MODIFY COLUMN `orphanInfo` TEXT NOT NULL;

ALTER TABLE `gecodroadmap`
  MODIFY COLUMN `content` LONGTEXT NOT NULL;

ALTER TABLE `gecodevents`
  MODIFY COLUMN `eventInfo`     TEXT         NOT NULL,
  MODIFY COLUMN `eventLocation` VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE `jobcareer`
  MODIFY COLUMN `JobDescription` TEXT NOT NULL,
  MODIFY COLUMN `qualifications`  TEXT NOT NULL,
  MODIFY COLUMN `experience`      TEXT NOT NULL,
  MODIFY COLUMN `deadlineDate`    DATE NULL;        -- critical: enables Open/Closed badge

-- 2. Fix teammembers image column (30 chars too short for generated filenames)
ALTER TABLE `teammembers`
  MODIFY COLUMN `image` VARCHAR(255) NOT NULL DEFAULT '';

-- 3. Add workingHours to jobcareer (skip if already done)
ALTER TABLE `jobcareer`
  ADD COLUMN IF NOT EXISTS `workingHours` VARCHAR(100) NOT NULL DEFAULT '';

-- 4. Expand paypal tables with donor/child tracking columns
ALTER TABLE `paypaldonations`
  ADD COLUMN IF NOT EXISTS `donor_name` VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE `paypalsponsors`
  ADD COLUMN IF NOT EXISTS `donor_name`   VARCHAR(255) NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `child_name`   VARCHAR(255) NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `paymentDate`  DATE         NULL;

-- 5. Add index on paypalsponsors.orphanid (speeds up sponsorship lookups)
ALTER TABLE `paypalsponsors`
  ADD INDEX IF NOT EXISTS `idx_orphanid` (`orphanid`);

-- 6. Enforce unique admin username
ALTER TABLE `gecodusers`
  ADD UNIQUE IF NOT EXISTS `uq_gecoduname` (`gecodUname`);

-- 7. Modernise payment table (was MyISAM/latin1)
ALTER TABLE `payment`
  ENGINE          = InnoDB,
  DEFAULT CHARSET = utf8mb4,
  COLLATE         = utf8mb4_unicode_ci;

-- 8. New table: newsletter subscribers (sendmail.php can write here)
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`         VARCHAR(255) NOT NULL,
  `subscribed_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
