<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Board_Block_Adminhtml_Board_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('board_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('validoc_board')->__('Designer Board Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('validoc_board')->__('General'),
            'title' => Mage::helper('validoc_board')->__('General'),
            'content' => $this->getLayout()->createBlock('validoc_board/adminhtml_board_edit_tab_general')->toHtml()
        ));

        $this->addTab('image_section', array(
            'label' => Mage::helper('validoc_board')->__('Images'),
            'title' => Mage::helper('validoc_board')->__('Images'),
            'content' => $this->getLayout()->createBlock('validoc_board/adminhtml_board_edit_tab_image')->toHtml()
        ));

        $this->addTab('categories', array(
            'label'     => Mage::helper('catalog')->__('Categories'),
            'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
            'class'     => 'ajax',
        ));

//        $this->addTab('video_section', array(
//            'label' => Mage::helper('cruiseline')->__('Videos'),
//            'title' => Mage::helper('cruiseline')->__('Videos'),
//            'content' => $this->getLayout()->createBlock('cruiseline/adminhtml_destination_edit_tab_video')->toHtml()
//        ));

        return parent::_beforeToHtml();
    }
}