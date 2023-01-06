CREATE TABLE `money` (
	`money_id` INT(11) NOT NULL AUTO_INCREMENT,
	`money_amount` DECIMAL(10,0) NOT NULL,
	`money_date` DATE NOT NULL,
	`money_added_datetime` DATETIME NOT NULL,
	`money_note` TINYTEXT NULL,
	`money_history` TEXT NULL,
	PRIMARY KEY (`money_id`)
)
ENGINE=InnoDB
;
