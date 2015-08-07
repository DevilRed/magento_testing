<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

$data = array(
    'label'         => 'Is Room',
    'type'          => 'int', // multiselect uses comma - sep storage
    'input'         => 'select',
    'source'        => 'eav/entity_attribute_source_boolean',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'visible'       => true,
    'required'      => false,
    'user_defined'  => false, // defaults to false; if true, define a group
    'group'         => 'General Information',
    'default'       => 0,
    'note'          => 'Set the category as room to load a different template',
);
$installer->addAttribute('catalog_category', 'is_room', $data);

$installer->endSetup();