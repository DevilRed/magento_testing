<?php
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('validoc_floorplan/floorplan')}`;
CREATE TABLE `{$this->getTable('validoc_floorplan/floorplan')}` (
  `floorplan_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `board_id` INT(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `is_active` INT(1) DEFAULT NULL,
  PRIMARY KEY (`floorplan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$this->getTable('validoc_floorplan/floorplan_product')}`;
CREATE TABLE `{$this->getTable('validoc_floorplan/floorplan_product')}` (
  `rel_id` INT(11) NOT NULL AUTO_INCREMENT,
  `floorplan_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `product_id` INT(11) NOT NULL DEFAULT 0,
  `position` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

");

$installer->endSetup();
