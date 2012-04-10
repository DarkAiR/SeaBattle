
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(128) NOT NULL,
	`password` VARCHAR(32) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user2room
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user2room`;

CREATE TABLE `user2room`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`room_id` INTEGER NOT NULL,
	`state` INTEGER DEFAULT 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `user2room_FI_1` (`user_id`),
	INDEX `user2room_FI_2` (`room_id`),
	CONSTRAINT `user2room_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`),
	CONSTRAINT `user2room_FK_2`
		FOREIGN KEY (`room_id`)
		REFERENCES `room` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- room
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `room`;

CREATE TABLE `room`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`state` INTEGER DEFAULT 0 NOT NULL,
	`time_stamp` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- field
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `field`;

CREATE TABLE `field`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`data` TEXT(400) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `field_FI_1` (`user_id`),
	CONSTRAINT `field_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
