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

ALTER TABLE `{$this->getTable('validoc_designer/designer')}` ADD COLUMN `web_site_designer` VARCHAR(200) CHARACTER SET utf8;

ALTER TABLE `{$this->getTable('validoc_designer/designer')}` MODIFY `biography` TEXT CHARACTER SET utf8;

");

$installer->endSetup();