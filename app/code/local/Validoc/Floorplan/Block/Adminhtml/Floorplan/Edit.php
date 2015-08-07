<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct() {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'validoc_floorplan'; //alias module
        $this->_controller = 'adminhtml_floorplan';
        $this->_mode = 'edit'; //_form
    }
    
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }

        $this->_updateButton('save','label',  Mage::helper('validoc_floorplan')->__('Save Floorplan'));
        $this->_updateButton('delete', 'label', Mage::helper('validoc_floorplan')->__('Delete Floorplan'));
        $this->_addButton('save and continue', array(
            'label' => Mage::helper('validoc_floorplan')->__('Save and Continue Edit'),
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
        if ($this->getFloorplan()->getId()) {
            $header = $this->htmlEscape($this->getFloorplan()->getName());
        } else {
            $header = Mage::helper('validoc_floorplan')->__('New Floorplan');
        }
        
        if ($setName = $this->getAttributeSetName()) {
            $header.= ' (' . $setName . ')';
        }
        
        return $header;
    }
    
    public function getAttributeSetName()
    {
        if ($setId = $this->getFloorplan()->getAttributeSetId()) {
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
    public function getFloorplan()
    {
        return Mage::registry('current_floorplan');
    }
}

