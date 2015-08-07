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

DROP TABLE IF EXISTS `{$this->getTable('validoc_board/board_image')}`;
CREATE TABLE `{$this->getTable('validoc_board/board_image')}` (
  `image_id` INT(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `position` smallint(5) DEFAULT '0',
  `disabled` tinyint(1) DEFAULT '1',
  `board_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `DESIGNER_BOARD_ID_IMAGE_ENTITY_ID` (`board_id`),
  CONSTRAINT `DESIGNER_BOARD_ID_IMAGE_ENTITY_ID` FOREIGN KEY (`board_id`) REFERENCES {$installer->getTable('validoc_board/board')} (`board_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `{$this->getTable('validoc_board/board_image_flag')}`;
CREATE TABLE `{$this->getTable('validoc_board/board_image_flag')}` (
  `board_id` INT(10) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `small_image` varchar(255) DEFAULT NULL,
  `medium_image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`board_id`),
  KEY `DESIGNER_BOARD_ID_IMAGE_FLAG_ENTITY_ID` (`board_id`),
  CONSTRAINT `DESIGNER_BOARD_ID_IMAGE_FLAG_ENTITY_ID` FOREIGN KEY (`board_id`) REFERENCES {$installer->getTable('validoc_board/board')} (`board_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


");


$installer->endSetup();