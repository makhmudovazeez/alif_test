SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `alif` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `alif` ;


CREATE TABLE IF NOT EXISTS `alif`.`rooms` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `alif`.`booking` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `room_id` BIGINT NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `from_date` DATETIME NOT NULL,
    `to_date` DATETIME NOT NULL,
    `emailed` BOOL DEFAULT FALSE,
    PRIMARY KEY (`id`),
    CONSTRAINT `booking_rooms_room_idFKrooms_id`
        FOREIGN KEY (`room_id`)
        REFERENCES `alif`.`rooms` (`id`)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_general_ci;

INSERT INTO `alif`.`rooms` (`name`) VALUES ('room 1');
INSERT INTO `alif`.`rooms` (`name`) VALUES ('room 2');
INSERT INTO `alif`.`rooms` (`name`) VALUES ('room 3');
INSERT INTO `alif`.`rooms` (`name`) VALUES ('room 4');
INSERT INTO `alif`.`rooms` (`name`) VALUES ('room 5');