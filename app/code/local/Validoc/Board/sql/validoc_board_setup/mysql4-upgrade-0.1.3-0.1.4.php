<?php
	$installer = $this;

	$installer->startSetup();

	$installer->run("

	ALTER TABLE `{$this->getTable('validoc_board/board')}` ADD COLUMN `type` INT(2) DEFAULT 0;

	");

	$installer->endSetup();