<?php
/**
 * Create Categories Seating, Sample Kit and Additional Item
 *
 * User: Juan Carlos Conde
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->removeAttribute('catalog_category', 'is_room', $data);

$installer->endSetup();