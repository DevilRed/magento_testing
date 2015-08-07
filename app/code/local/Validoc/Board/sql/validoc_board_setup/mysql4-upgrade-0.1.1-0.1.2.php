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

DROP TABLE IF EXISTS `validoc_board_category`;
CREATE TABLE `validoc_board_category` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `board_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Board ID',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  PRIMARY KEY (`category_id`,`board_id`),
  KEY `IDX_CATEGORY_BOARD_BOARD_ID` (`board_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Board To Category Linkage Table'

");


$installer->endSetup();