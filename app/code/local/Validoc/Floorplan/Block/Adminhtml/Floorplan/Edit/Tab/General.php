<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

    protected $_prefix = 'floorplan_';

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix($this->_prefix);
        $fieldset = $form->addFieldset ( '_general_form',
            array (
                'legend' => Mage::helper('validoc_floorplan')->__('General'),
                'class' => 'fieldset-wide'
            ) 
        );

        $boardCollection = Mage::getResourceModel('validoc_board/board_collection')
            ->addFieldToSelect('board_id')
            ->addFieldToSelect('name');

        $options = array();
        foreach($boardCollection as $model) {
            $option = array('value' => $model->getId(),'label' => $model->getName());
            $options[] = $option;
        }

        $fieldset->addField('board_id', 'select', array(
            'name' => 'board_id',
            'label' => Mage::helper('validoc_floorplan')->__('Board'),
            'title' => Mage::helper('validoc_floorplan')->__('Board'),
            'required' => true,
            'values' => $options
        ));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('validoc_floorplan')->__('Name'),
            'title' => Mage::helper('validoc_floorplan')->__('Name'),
            'required' => true
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('validoc_floorplan')->__('Is Active'),
            'title' => Mage::helper('validoc_floorplan')->__('Is Active'),
            'required' => false,
            'values' => array('0' => 'No','1' => 'Yes')
        ));

	$fieldset->addField('image', 'image', array(
            'name' => 'image',
            'label' => Mage::helper('validoc_floorplan')->__('Picture'),
            'title' => Mage::helper('validoc_floorplan')->__('Picture'),
            'required' => false
        ));

        $fieldset->addField('description', 'editor', array(
            'name' => 'description',
            'label' => Mage::helper('validoc_floorplan')->__('Description'),
            'title' => Mage::helper('validoc_floorplan')->__('Description'),
            'style' => 'width:700px; height:400px;',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg' => true,
            'required' => true
        ));
        
        $form->addValues(Mage::registry('current_floorplan')->toArray());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

    public function getJsObjectName() {
        return $this->getId().'JsObject';
    }
}
