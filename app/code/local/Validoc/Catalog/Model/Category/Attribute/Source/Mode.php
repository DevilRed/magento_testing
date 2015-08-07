<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 5/29/2015
 * Time: 12:51 PM
 */ 
class Validoc_Catalog_Model_Category_Attribute_Source_Mode extends Mage_Catalog_Model_Category_Attribute_Source_Mode
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = array(
                array(
                    'value' => Mage_Catalog_Model_Category::DM_PRODUCT,
                    'label' => Mage::helper('catalog')->__('Products only'),
                ),
                array(
                    'value' => Mage_Catalog_Model_Category::DM_PAGE,
                    'label' => Mage::helper('catalog')->__('Static block only'),
                ),
                array(
                    'value' => Mage_Catalog_Model_Category::DM_MIXED,
                    'label' => Mage::helper('catalog')->__('Static block and products'),
                ),
                array(
                    'value' => Validoc_Catalog_Model_Category::DM_SUBCATEGORIES,
                    'label' => Mage::helper('catalog')->__('Subcategories only'),
                ),
                array(
                    'value' => Validoc_Catalog_Model_Category::DM_BOARDS,
                    'label' => Mage::helper('catalog')->__('Boards only'),
                )
            );
        }
        return $this->_options;
    }
}