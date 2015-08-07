<?php
/**
 * Create Categories Seating, Sample Kit and Additional Item
 *
 * User: Juan Carlos Conde
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/* supply parent id */
$rootCatId = Mage::app()->getStore()->getRootCategoryId();

/* Category Seating */
$category = Mage::getModel('catalog/category')->loadByAttribute('name', 'Seating');
if (!$category) {
    $category = new Mage_Catalog_Model_Category();
    $category->setName('Seating');
    $category->setUrlKey('seating');
    $category->setIsActive(1);
    $category->setIsAnchor(0);
    $category->setIncludeInMenu(0);

    $parentCategory = Mage::getModel('catalog/category')->load($rootCatId);
    $category->setPath($parentCategory->getPath());
    $category->save();
}

/* Category Sample Kit */
$category = Mage::getModel('catalog/category')->loadByAttribute('name', 'Sample Kit');
if (!$category) {
    $category = new Mage_Catalog_Model_Category();
    $category->setName('Sample Kit');
    $category->setUrlKey('sample-kit');
    $category->setIsActive(1);
    $category->setIsAnchor(0);
    $category->setIncludeInMenu(0);

    $parentCategory = Mage::getModel('catalog/category')->load($rootCatId);
    $category->setPath($parentCategory->getPath());
    $category->save();
}

/* Category Additional Item */
$category = Mage::getModel('catalog/category')->loadByAttribute('name', 'Additional Item');
if (!$category) {
    $category = new Mage_Catalog_Model_Category();
    $category->setName('Additional Item');
    $category->setUrlKey('additional-item');
    $category->setIsActive(1);
    $category->setIsAnchor(0);
    $category->setIncludeInMenu(0);

    $parentCategory = Mage::getModel('catalog/category')->load($rootCatId);
    $category->setPath($parentCategory->getPath());
    $category->save();
}

$installer->endSetup();