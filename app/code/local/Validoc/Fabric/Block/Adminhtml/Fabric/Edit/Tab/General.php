<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Fabric_Block_Adminhtml_Fabric_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

    protected $_prefix = 'fabric_';

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix($this->_prefix);
        $fieldset = $form->addFieldset ( '_general_form',
            array (
                'legend' => Mage::helper('validoc_fabric')->__('General'),
                'class' => 'fieldset-wide'
            ) 
        );

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('validoc_fabric')->__('Name'),
            'title' => Mage::helper('validoc_fabric')->__('Name'),
            'required' => true
        ));

        /*$fieldset->addField('manufacturer', 'text', array(
            'name' => 'manufacturer',
            'label' => Mage::helper('validoc_fabric')->__('Manufacturer'),
            'title' => Mage::helper('validoc_fabric')->__('Manufacturer'),
            'required' => true
        ));*/

        $fieldset->addField('manufacturer', 'select', array(
            'name' => 'manufacturer',
            'label' => Mage::helper('validoc_fabric')->__('Source'),
            'title' => Mage::helper('validoc_fabric')->__('Source'),
            'type'  => 'varchar',
            'visible'   => true,
            'required'  => true,
            'values'    => $this->getItensManufacturer(),
            'style' => 'width:99%;',
        ));

        $fieldset->addField('color', 'multiselect', array(
            'name' => 'color',
            'label' => Mage::helper('validoc_fabric')->__('Color'),
            'title' => Mage::helper('validoc_fabric')->__('Color'),
            'type'  => 'varchar',
            'visible'   => true,
            'required'  => true,
            'values'    => $this->getItensColor(),
            'style' => 'width:99%;',
        ));
        
        $fieldset->addField('room', 'multiselect', array(
                'name' => 'room',
                'label' => Mage::helper('validoc_fabric')->__('Room'),
                'title' => Mage::helper('validoc_fabric')->__('Room'),
                'type' => 'varchar',
                'visible' => true,
                'required' => false,
                'values' => $this->getRooms(),
                'style' => 'width:99%;'
            ));
        $fieldset->addField('description', 'textarea', array(
                'name' => 'description',
                'label' => Mage::helper('validoc_fabric')->__('Description'),
                'title' => Mage::helper('validoc_fabric')->__('Description'),
                'type' => 'text',
                'visible' => true,
                'required' => false,
                'style' => 'width:99%'
            ));
        $form->addValues(Mage::registry('current_fabric')->toArray());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

    public function getJsObjectName() {
        return $this->getId().'JsObject';
    }
    private function getItensManufacturer(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('manufacturer')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        return $attributeOptions;

    }
    private function getItensColor(){
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('color')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        return $attributeOptions;

    }
    private function getRooms(){
        $boardModel = Mage::getModel('validoc_board/board');
        $collection = $boardModel->getCollection();
        $collection->addFieldToSelect('board_id');
        $collection->addFieldToSelect('name');
        $roomValues = array();
        $collection->addFieldToSelect('type');
        foreach ($collection as $key => $value) {
            $typeCode = $value->getType();
            if($typeCode == 1){
                $typeLabel = 'Sitting Room';
            }else if($typeCode == 2){
                $typeLabel = 'Decor Vignettes';
            }
            $label = $value->getName()." - ".$typeLabel;
            $data = array(
                'value' => $value->getBoardId(),
                'label' => $label
                );
            array_push($roomValues, $data);
        }
        return $roomValues;
    }

}