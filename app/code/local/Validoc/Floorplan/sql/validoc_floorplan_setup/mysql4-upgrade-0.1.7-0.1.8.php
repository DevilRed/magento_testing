<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_floorplan/floorplan')}` ADD COLUMN `is_ghost` INT(2) DEFAULT 0;

	");

	$installer->endSetup();