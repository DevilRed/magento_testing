<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_floorplan/floorplan')}` MODIFY `serialized_grid` TEXT DEFAULT NULL;

	");

	$installer->endSetup();