ALTER TABLE `money`
	ADD COLUMN `money_type` INT NOT NULL DEFAULT '1' AFTER `money_note`;
