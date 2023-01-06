ALTER TABLE `money`
	CHANGE COLUMN `money_amount` `money_amount_income` DECIMAL(19,0) NOT NULL DEFAULT '0' AFTER `money_id`,
	ADD COLUMN `money_amount_expense` DECIMAL(19,0) NOT NULL DEFAULT '0' AFTER `money_amount_income`;
