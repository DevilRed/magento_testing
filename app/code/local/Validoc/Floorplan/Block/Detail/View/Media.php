<?php

class Validoc_Floorplan_Block_Detail_View_Media extends Mage_Core_Block_Template
{
    /**
     * Flag, that defines whether gallery is disabled
     *
     * @var boolean
     */
    protected $_isGalleryDisabled;

    /**
     * Retrieve list of gallery images
     *
     * @return array|Varien_Data_Collection
     */
    public function getBoardGalleryImages()
    {
        if ($this->_isGalleryDisabled) {
            return array();
        }
        $board = Mage::getModel('validoc_board/board')->load($this->getFloorplan()->getBoardId());
        $collection = $board->getMediaGallery();
        return $collection;
    }


    /**
     * Retrieve gallery url
     *
     * @param null|Varien_Object $image
     * @return string
     */
    public function getGalleryUrl($image = null)
    {
        $params = array('id' => $this->getFloorplan()->getId());
        if ($image) {
            $params['image'] = $image->getValueId();
        }
        return $this->getUrl('catalog/product/gallery', $params);
    }

    /**
     * Disable gallery
     */
    public function disableGallery()
    {
        $this->_isGalleryDisabled = true;
    }

    /**
     * Retrieve current product model
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getFloorplan()
    {
        if (!Mage::registry('current_floorplan')) {
            $floorplanId  = (int) $this->getRequest()->getParam('id');
            $floorplan = Mage::getModel('validoc_floorplan/floorplan')->load($floorplanId);
            Mage::register('current_floorplan', $floorplan);
        }
        return Mage::registry('current_floorplan');
    }

    public function getImageLabel($floorplan = null, $mediaAttributeCode = 'image')
    {
        if (is_null($floorplan)) {
            $floorplan = $this->getFloorplan();
        }

        $label = $floorplan->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $floorplan->getName();
        }

        return $label;
    }
}
