<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('validoc_fabric/fabric')}` ADD COLUMN `color` varchar(120) NULL;

");

$installer->endSetup();