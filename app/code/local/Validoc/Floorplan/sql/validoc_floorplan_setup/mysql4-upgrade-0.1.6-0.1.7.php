<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_floorplan/floorplan')}` ADD COLUMN `approximate_cost` VARCHAR(255) DEFAULT NULL;

	");

	$installer->endSetup();