
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- comment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment`
(
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`Value` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- displayedNumber
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `displayedNumber`;

CREATE TABLE `displayedNumber`
(
	`Id` INTEGER NOT NULL AUTO_INCREMENT,
	`Numbers` TEXT,
	PRIMARY KEY (`Id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
