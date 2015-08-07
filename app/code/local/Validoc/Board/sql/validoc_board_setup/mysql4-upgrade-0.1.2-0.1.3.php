<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('validoc_board/board')}` ADD COLUMN `is_active` INT(2) DEFAULT 0;

");

$installer->endSetup();