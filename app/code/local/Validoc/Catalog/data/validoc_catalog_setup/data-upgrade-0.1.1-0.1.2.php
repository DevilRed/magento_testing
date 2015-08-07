<?php
/**
 * Create Categories Seating, Sample Kit and Additional Item
 *
 * User: Juan Carlos Conde
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

$installer->addAttribute('catalog_category', 'title_image', array(
    'input'         => 'image',
    'type'          => 'varchar',
    'group'         => 'General Information',
    'label'         => 'Title Image',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => false,
    'frontend_input' =>'',
    'default'       => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'backend' => 'catalog/category_attribute_backend_image',
    'visible_on_front'  => 1,
    'sort_order'    => 4
));

$installer->endSetup();