<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/9/14
 * Time: 11:00 AM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('validoc_designer/designer')}`;
CREATE TABLE `{$this->getTable('validoc_designer/designer')}` (
  `designer_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `biography` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`designer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

");

$installer->endSetup();