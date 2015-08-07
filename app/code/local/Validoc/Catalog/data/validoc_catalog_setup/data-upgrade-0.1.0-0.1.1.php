<?php
/**
 * Create Categories Seating, Sample Kit and Additional Item
 *
 * User: Juan Carlos Conde
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$content = '{{block type="catalog/navigation" name="catalog.categories" template="catalog/navigation/category_listing.phtml"}}';
//if you want one block for each store view, get the store collection
//$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();
//if you want one general block for all the store viwes, uncomment the line below
//$stores = array(0);
//foreach ($stores as $store){
    $block = Mage::getModel('cms/block');
    $block->setTitle('Category Listing');
    $block->setIdentifier('category_listing');
    $block->setStores(array(0));
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
//}

$installer->endSetup();