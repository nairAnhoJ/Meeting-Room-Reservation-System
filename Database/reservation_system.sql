-- Create Database with a name of "reservation_system" before importing

CREATE TABLE `reservation_system`.`users` (
    `user_id` INT NOT NULL AUTO_INCREMENT ,
    `idNum` VARCHAR(255) NOT NULL ,
    `full_name` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL ,
    `department` VARCHAR(255) NOT NULL ,
    `passwd` VARCHAR(255) NOT NULL ,
    `head` INT NOT NULL ,
    `role` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;


CREATE TABLE `reservation_system`.`room` (
    `room_id` INT NOT NULL AUTO_INCREMENT ,
    `room_name` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`room_id`)
) ENGINE = InnoDB;


CREATE TABLE `reservation_system`.`reservation` (
    `reserve_id` INT NOT NULL AUTO_INCREMENT ,
    `user_id` INT NOT NULL ,
    `room_id` INT NOT NULL ,
    `description` VARCHAR(255) NOT NULL ,
    `status` VARCHAR(255) NOT NULL ,
    `start_date` DATE NOT NULL ,
    `end_date` DATE NOT NULL ,
    `start_time` TIME NOT NULL ,
    `end_time` TIME NOT NULL ,
    PRIMARY KEY (`reserve_id`)
) ENGINE = InnoDB;