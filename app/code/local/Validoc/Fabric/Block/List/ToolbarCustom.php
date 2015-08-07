<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 01-09-14
 * Time: 06:40 PM
 */
class Validoc_Fabric_Block_List_ToolbarCustom extends Mage_Core_Block_Template
{

    public  function getManufacturer(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('manufacturer')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        //print_r($attributeOptions);
        return $attributeOptions;

    }
    public  function getColor(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('color')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        //print_r($attributeOptions);
        return $attributeOptions;

    }
}