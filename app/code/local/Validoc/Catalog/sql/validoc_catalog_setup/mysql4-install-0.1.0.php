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

$installer->removeAttribute('catalog_product', Validoc_Board_Model_Board::ATTRIBUTE_CODE);

$allowedProductTypes = array(
    Mage_Catalog_Model_Product_Type::TYPE_SIMPLE,
    Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE,
    Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
    Mage_Catalog_Model_Product_Type::TYPE_GROUPED,
    Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE,
    Mage_Catalog_Model_Product_Type::TYPE_BUNDLE
);
$data = array( // Array containing all settings:
    'type'          => 'int', // multiselect uses comma - sep storage
    'input'         => 'select',
    "label"         => "Fabric",
    "global"        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    // Dont know if this is really necessary, but it makes sure
    // the attribute is created as a system attribute:
    "user_defined"  => false,
    'required'      => true,
    'visible_on_front'  => false,
    'searchable' => true,
    'visible_in_advanced_search' => true,
    'source'        => 'validoc_catalog/attribute_source_fabric',
    'group'         => 'General',
    'default'           => '0',
    // This makes sure the attribute only applies to grouped products
    "apply_to"      => implode(',', $allowedProductTypes)
);
$installer->addAttribute("catalog_product", Validoc_Fabric_Model_Fabric::ATTRIBUTE_CODE, $data);
//$installer->updateAttribute('catalog_product','shipoperator_id','source_model','cruiseline/attribute_source_shipoperator');
//$installer->updateAttribute('catalog_product','shipoperator_id','frontend_input_renderer','Southernmonkeys_Cruiseline_Model_Attribute_Source_Renderer_Shipoperator');


$installer->endSetup();