<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('floorplan_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('validoc_floorplan')->__('Floorplan Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('validoc_floorplan')->__('General'),
            'title' => Mage::helper('validoc_floorplan')->__('General'),
            'content' => $this->getLayout()->createBlock('validoc_floorplan/adminhtml_floorplan_edit_tab_general')->toHtml()
        ));

	$this->addTab('products', array(
            'label' => Mage::helper('validoc_floorplan')->__('Products Grid'),
            'url'   => $this->getUrl('*/*/products', array('_current' => true)),
            'class'    => 'ajax'
        ));

        $this->addTab('frontend_grid', array(
                'label' => Mage::helper('validoc_floorplan')->__('Frontend Grid'),
                'content' => $this->getLayout()->createBlock('validoc_floorplan/adminhtml_floorplan_edit_tab_customization')->toHtml()
            ));

        return parent::_beforeToHtml();
    }
}
