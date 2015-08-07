<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/9/14
 * Time: 6:25 AM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('validoc_fabric/fabric')}`;
CREATE TABLE `{$this->getTable('validoc_fabric/fabric')}` (
  `fabric_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fabric_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

");

$installer->endSetup();