CREATE TABLE `inventory_import` (
	`import_id` INT(11) NOT NULL AUTO_INCREMENT,
	`import_merchant_id` INT(11) NOT NULL,
	`import_cart_big` INT(11) NOT NULL,
	`import_cart_small` INT(11) NOT NULL,
	`import_inventories` VARCHAR(200) NOT NULL,
	`import_datetime` DATETIME NOT NULL,
	`import_added_by` INT(11) NOT NULL,
	`import_added_datetime` DATETIME NOT NULL,
	PRIMARY KEY (`import_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
