<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Designer_Block_Adminhtml_Designer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct() {
        parent::_construct();
//        $this->_blockGroup . '/' . $this->_controller . '/' . $this->_mode  . '_form';
        $this->_objectId = 'id';
        $this->_blockGroup = 'validoc_designer'; //alias module
        $this->_controller = 'adminhtml_designer';
        $this->_mode = 'edit'; //_form
    }
    
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }

        $this->_updateButton('save','label',  Mage::helper('validoc_designer')->__('Save Designer'));
        $this->_updateButton('delete', 'label', Mage::helper('validoc_designer')->__('Delete Designer'));
        $this->_addButton('save and continue', array(
            'label' => Mage::helper('validoc_designer')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save'
        ), 100);
        
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action + 'back/edit/');
            }
        ";
        
        return $this;
    }
    
    public function getHeaderText() {
        if ($this->getDesigner()->getId()) {
            $header = $this->htmlEscape($this->getDesigner()->getName());
        } else {
            $header = Mage::helper('validoc_designer')->__('New Designer');
        }
        
        if ($setName = $this->getAttributeSetName()) {
            $header.= ' (' . $setName . ')';
        }
        
        return $header;
    }
    
    public function getAttributeSetName()
    {
        if ($setId = $this->getDesigner()->getAttributeSetId()) {
            $set = Mage::getModel('eav/entity_attribute_set')
                ->load($setId);
            return $set->getAttributeSetName();
        }
        return '';
    }
    
    /**
     * Retrieve currently edited product object
     *
     * @return Southernmonkeys_Cruiseline_Model_Ship_Cabin_Category
     */
    public function getDesigner()
    {
        return Mage::registry('current_designer');
    }
}

