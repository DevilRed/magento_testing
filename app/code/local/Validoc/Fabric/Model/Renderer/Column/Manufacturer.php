<?php


class Validoc_Fabric_Model_Renderer_Column_Manufacturer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row)
    {

        $value =  $row->getData($this->getColumn()->getIndex());
        $value = explode(',', $value);
        $options = $this->getItensManufacturer();
        $manufacturers = array();
        if (count($options) > 0) {
            foreach($options as $key => $option) {
                if (in_array($option['value'], $value)) {
                    $manufacturers[] = $option['label'];
                }
            }
        }
        return '<span>'.implode(',', $manufacturers).'</span>';
    }

    private function getItensManufacturer(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('manufacturer')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        //print_r($attributeOptions);
        return $attributeOptions;

    }
}