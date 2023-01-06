CREATE TABLE `merchant` (
	`merchant_id` INT(11) NOT NULL AUTO_INCREMENT,
	`merchant_name` VARCHAR(100) NOT NULL,
	`merchant_added_by` INT(11) NOT NULL,
	`merchant_added_datetime` DATETIME NOT NULL,
	PRIMARY KEY (`merchant_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
