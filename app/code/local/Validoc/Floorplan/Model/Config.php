<?php
class Validoc_Floorplan_Model_Config extends Mage_Catalog_Model_Config
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

        return $options;
    }
}
