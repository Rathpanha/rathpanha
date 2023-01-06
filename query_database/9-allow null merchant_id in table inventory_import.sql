ALTER TABLE `inventory_import`
	ALTER `import_merchant_id` DROP DEFAULT;
ALTER TABLE `inventory_import`
	CHANGE COLUMN `import_merchant_id` `import_merchant_id` INT(11) NULL AFTER `import_id`;
