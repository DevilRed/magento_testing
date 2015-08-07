<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Fabric_Block_Adminhtml_Fabric_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('fabric_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('validoc_fabric')->__('Fabric Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('validoc_fabric')->__('General'),
            'title' => Mage::helper('validoc_fabric')->__('General'),
            'content' => $this->getLayout()->createBlock('validoc_fabric/adminhtml_fabric_edit_tab_general')->toHtml()
        ));

        $this->addTab('image_section', array(
            'label' => Mage::helper('validoc_fabric')->__('Images'),
            'title' => Mage::helper('validoc_fabric')->__('Images'),
            'content' => $this->getLayout()->createBlock('validoc_fabric/adminhtml_fabric_edit_tab_image')->toHtml()
        ));
//
//        $this->addTab('video_section', array(
//            'label' => Mage::helper('cruiseline')->__('Videos'),
//            'title' => Mage::helper('cruiseline')->__('Videos'),
//            'content' => $this->getLayout()->createBlock('cruiseline/adminhtml_destination_edit_tab_video')->toHtml()
//        ));

        return parent::_beforeToHtml();
    }
}