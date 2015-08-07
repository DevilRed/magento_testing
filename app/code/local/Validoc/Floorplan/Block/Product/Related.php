<?php
class Validoc_Floorplan_Block_Product_Related extends Mage_Catalog_Block_Product_Abstract
{
    public function getFloorplan() {
        return Mage::registry('current_floorplan');
    }

    public function getSampleKits() {
        $floorplan = $this->getFloorplan();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Sample Kit');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('floorplan_id', array('finset'=>$floorplan->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }

    public function getAdditionalItems() {
        $floorplan = $this->getFloorplan();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Additional Item');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('floorplan_id', array('finset'=>$floorplan->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }

    public function getSeatings() {
        $floorplan = $this->getFloorplan();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Seating');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('floorplan_id', array('finset'=>$floorplan->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }
}
