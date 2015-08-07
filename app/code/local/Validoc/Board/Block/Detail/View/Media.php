<?php

class Validoc_Board_Block_Detail_View_Media extends Mage_Core_Block_Template
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
    public function getGalleryImages()
    {
        if ($this->_isGalleryDisabled) {
            return array();
        }
        $collection = $this->getBoard()->getMediaGalleryImages();
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
        $params = array('id' => $this->getBoard()->getId());
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
    public function getBoard()
    {
        if (!Mage::registry('current_board')) {
            $boardId  = (int) $this->getRequest()->getParam('id');
            $board = Mage::getModel('validoc_board/board')->load($boardId);
            Mage::register('current_board', $board);
        }
        return Mage::registry('current_board');
    }

    public function getImageLabel($board = null, $mediaAttributeCode = 'image')
    {
        if (is_null($board)) {
            $board = $this->getBoard();
        }

        $label = $board->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $board->getName();
        }

        return $label;
    }

    public function getMainImage(){
        $collection = $this->getBoard()->getMediaGalleryImages();
        $position = null;
        $mainImage;
        foreach ($collection as $k => $v) {
            if(!isset($position)){
                $position = $v->getPosition();
                $mainImage = $v;
            }
            if($v->getPosition() < $position){
                $position = $v->getPosition();
                $mainImage = $v;
            }
        }
        return $mainImage;
    }
}
