<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/11/14
 * Time: 3:09 AM
 */ 
class Validoc_Catalog_Model_Product extends Mage_Catalog_Model_Product
{
    /**
     * @return bool|Validoc_Fabric_Model_Fabric
     */
    public function getFabric() {
        // check if has attribute exists
        $attr = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product',Validoc_Fabric_Model_Fabric::ATTRIBUTE_CODE);
        if ($attr->getId() !== null) {
            $fabric_id = $this->getData(Validoc_Fabric_Model_Fabric::ATTRIBUTE_CODE);
            $fabric = Mage::getModel('validoc_fabric/fabric')->load($fabric_id);
            return $fabric;
        }
        return false;
    }
}