<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_board/board')}` ADD COLUMN `serialized_grid` TEXT DEFAULT NULL;

	");

	$installer->endSetup();