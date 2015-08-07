<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Board_Block_Adminhtml_Board_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct() {
        parent::_construct();
//        $this->_blockGroup . '/' . $this->_controller . '/' . $this->_mode  . '_form';
        $this->_objectId = 'id';
        $this->_blockGroup = 'validoc_board'; //alias module
        $this->_controller = 'adminhtml_board';
        $this->_mode = 'edit'; //_form
    }
    
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }

        $this->_updateButton('save','label',  Mage::helper('validoc_board')->__('Save Designer Board'));
        $this->_updateButton('delete', 'label', Mage::helper('validoc_board')->__('Delete Designer Board'));
        $this->_addButton('save and continue', array(
            'label' => Mage::helper('validoc_board')->__('Save and Continue Edit'),
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
        if ($this->getBoard()->getId()) {
            $header = $this->htmlEscape($this->getBoard()->getName());
        } else {
            $header = Mage::helper('validoc_board')->__('New Designer Board');
        }
        
        if ($setName = $this->getAttributeSetName()) {
            $header.= ' (' . $setName . ')';
        }
        
        return $header;
    }
    
    public function getAttributeSetName()
    {
        if ($setId = $this->getBoard()->getAttributeSetId()) {
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
    public function getBoard()
    {
        return Mage::registry('current_board');
    }
}

