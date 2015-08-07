<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 28-08-14
 * Time: 05:45 PM
 */
class Validoc_Fabric_Model_Renderer_Column_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {

        $value =  $row->getData($this->getColumn()->getIndex());
        $value = explode(',', $value);
        $options = $this->getItensColor();
        $colors = array();
        if (count($options) > 0) {
            foreach($options as $key => $option) {
                if (in_array($option['value'], $value)) {
                    $colors[] = $option['label'];
                }
            }
        }
        Mage::log($colors);
        return '<span>'.implode(',', $colors).'</span>';
    }

    private function getItensColor(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('color')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        return $attributeOptions;

    }
}