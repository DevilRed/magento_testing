<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/9/14
 * Time: 10:57 AM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('validoc_board/board')}`;
CREATE TABLE `{$this->getTable('validoc_board/board')}` (
  `board_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `designer_id` INT(11) NOT NULL,
  PRIMARY KEY (`board_id`),
  KEY `DESIGNER_ID_BOARD_ENTITY_ID` (`designer_id`),
  CONSTRAINT `DESIGNER_ID_BOARD_ENTITY_ID` FOREIGN KEY (`designer_id`) REFERENCES {$installer->getTable('validoc_designer/designer')} (`designer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

");


$installer->endSetup();