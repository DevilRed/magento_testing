<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_floorplan/floorplan')}` ADD COLUMN `serialized_grid` VARCHAR(255) DEFAULT NULL;

	");

	$installer->endSetup();