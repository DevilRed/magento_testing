<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Board_Block_Adminhtml_Board_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

    protected $_prefix = 'board_';

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix($this->_prefix);
        $fieldset = $form->addFieldset ( '_general_form',
            array (
                'legend' => Mage::helper('validoc_board')->__('General'),
                'class' => 'fieldset-wide'
            ) 
        );

        // cargar designer en el drop down
        $designerCollection = Mage::getResourceModel('validoc_designer/designer_collection')
            ->addFieldToSelect('designer_id')
            ->addFieldToSelect('name');

        $options = array();
        foreach($designerCollection as $model) {
            $option = array('value' => $model->getId(),'label' => $model->getName());
            $options[] = $option;
        }

        $fieldset->addField('designer_id', 'select', array(
            'name' => 'designer_id',
            'label' => Mage::helper('validoc_board')->__('Designer'),
            'title' => Mage::helper('validoc_board')->__('Designer'),
            'required' => true,
            'values' => $options
        ));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('validoc_board')->__('Name'),
            'title' => Mage::helper('validoc_board')->__('Name'),
            'required' => true
        ));

        $fieldset->addField('type', 'select', array(
            'name' => 'type',
            'label' => Mage::helper('validoc_board')->__('Type'),
            'title' => Mage::helper('validoc_board')->__('Type'),
            'required' => false,
            'values' => array('-1' => 'Please Select..', '1' => 'Sitting Rooms', '2' => 'Decor Vignettes')
            ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('validoc_board')->__('Is Active'),
            'title' => Mage::helper('validoc_board')->__('Is Active'),
            'required' => false,
            'values' => array('0' => 'No','1' => 'Yes')
        ));

        $fieldset->addField('description', 'editor', array(
            'name' => 'description',
            'label' => Mage::helper('validoc_board')->__('Description'),
            'title' => Mage::helper('validoc_board')->__('Description'),
            'style' => 'width:700px; height:400px;',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg' => true,
            'required' => true
        ));
        
        $form->addValues(Mage::registry('current_board')->toArray());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

    public function getJsObjectName() {
        return $this->getId().'JsObject';
    }
}