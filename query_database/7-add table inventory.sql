CREATE TABLE `inventory` (
	`inventory_id` INT(11) NOT NULL AUTO_INCREMENT,
	`inventory_name` VARCHAR(100) NOT NULL,
	`inventory_added_by` INT(11) NOT NULL,
	`inventory_added_datetime` DATETIME NOT NULL,
	PRIMARY KEY (`inventory_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;