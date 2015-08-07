<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Designer_Block_Adminhtml_Designer_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

    protected $_prefix = 'designer_';

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix($this->_prefix);
        $fieldset = $form->addFieldset ( '_general_form',
            array (
                'legend' => Mage::helper('validoc_designer')->__('General'),
                'class' => 'fieldset-wide'
            ) 
        );

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('validoc_designer')->__('Name'),
            'title' => Mage::helper('validoc_designer')->__('Name'),
            'required' => true
        ));

        $fieldset->addField('city', 'text', array(
            'name' => 'city',
            'label' => Mage::helper('validoc_designer')->__('City'),
            'title' => Mage::helper('validoc_designer')->__('City'),
            'required' => true
        ));

        $fieldset->addField('firm_name', 'text', array(
            'name' => 'firm_name',
            'label' => Mage::helper('validoc_designer')->__('Firm Name'),
            'title' => Mage::helper('validoc_designer')->__('Firm Name'),
            'required' => true
        ));

        $fieldset->addField('type', 'select', array(
            'name' => 'type',
            'label' => Mage::helper('validoc_designer')->__('Type'),
            'title' => Mage::helper('validoc_designer')->__('Type'),
            'required' => true,
            'values' => array('1' => 'Designer','2' => 'Collaborator'),
        ));

        $fieldset->addField('web_site_designer', 'text', array(
            'name' => 'web_site_designer',
            'label' => Mage::helper('validoc_designer')->__('Web Site Designer'),
            'title' => Mage::helper('validoc_designer')->__('Web Site Designer'),
            'required' => false,
            'class' => 'validate-url',
        ));

        $fieldset->addField('excerpt', 'editor', array(
            'name' => 'excerpt',
            'label' => Mage::helper('validoc_designer')->__('Excerpt'),
            'title' => Mage::helper('validoc_designer')->__('Excerpt'),
            'style' => 'width:700px; height:100px;',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg' => true,
            'required' => true
        ));

        $fieldset->addField('biography', 'editor', array(
            'name' => 'biography',
            'label' => Mage::helper('validoc_designer')->__('Biography'),
            'title' => Mage::helper('validoc_designer')->__('Biography'),
            'style' => 'width:700px; height:200px;',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg' => true,
            'required' => true
        ));
        $form->addValues(Mage::registry('current_designer')->toArray());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

    public function getJsObjectName() {
        return $this->getId().'JsObject';
    }
}