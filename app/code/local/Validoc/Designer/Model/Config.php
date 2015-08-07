<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/23/14
 * Time: 5:40 PM
 */
class Validoc_Designer_Model_Config extends Mage_Catalog_Model_Config
{
    /**
     * Retrieve Product List Default Sort By
     *
     * @param mixed $store
     * @return string
     */
    public function getProductListDefaultSortBy($store = null) {
        return "name";
    }

    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $options = array(
            'name'  => Mage::helper('catalog')->__('Name')
        );
//        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
//            /* @var $attribute Mage_Eav_Model_Entity_Attribute_Abstract */
//            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
//        }

        return $options;
    }
}