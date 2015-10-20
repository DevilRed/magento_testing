<?php

$installer = $this;
$installer->startSetup();

$installer->run("
	ALTER TABLE `{$this->getTable('validoc_fabric/fabric')}` ADD COLUMN `construction` varchar(255) NULL;
");

$installer->endSetup();