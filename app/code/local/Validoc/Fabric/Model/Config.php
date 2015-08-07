<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 19-08-14
 * Time: 05:25 PM
 */
class Validoc_Fabric_Model_Config extends Mage_Catalog_Model_Config
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