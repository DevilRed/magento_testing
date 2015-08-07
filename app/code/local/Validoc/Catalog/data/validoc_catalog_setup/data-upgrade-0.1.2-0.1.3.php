<?php
/**
 * Create Categories Seating, Sample Kit and Additional Item
 *
 * User: Juan Carlos Conde
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

$installer->removeAttribute('catalog_category', 'title_image');

$installer->addAttribute('catalog_category', 'name_suffix', array(
    'input'         => 'text',
    'type'          => 'varchar',
    'group'         => 'General Information',
    'label'         => 'Name Suffix',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => false,
    'frontend_input' =>'',
    'default'       => '',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible_on_front'  => 1,
    'sort_order'    => 2
));

$installer->endSetup();