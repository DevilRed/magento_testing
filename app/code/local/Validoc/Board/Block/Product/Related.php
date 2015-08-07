<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/4/14
 * Time: 9:24 AM
 */
class Validoc_Board_Block_Product_Related extends Mage_Catalog_Block_Product_Abstract
{
    public function getBoard() {
        return Mage::registry('current_board');
    }

    public function getSampleKits() {
        $board = $this->getBoard();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Sample Kit');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('board_id', array('finset'=>$board->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }

    public function getAdditionalItems() {
        $board = $this->getBoard();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Additional Item');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('board_id', array('finset'=>$board->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }

    public function getSeatings() {
        $board = $this->getBoard();

        $category = Mage::getModel('catalog/category')->loadByAttribute('name','Seating');
        if (!$category) {
            return new Varien_Data_Collection();
        }
        $collection = $category->getProductCollection();

//        $collection->addAttributeToFilter('board_id', array('finset'=>$board->getId()));
        $collection->addAttributeToSelect('*');

        return $collection;
    }
}