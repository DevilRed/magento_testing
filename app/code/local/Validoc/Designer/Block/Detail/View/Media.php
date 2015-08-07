<?php

class Validoc_Designer_Block_Detail_View_Media extends Mage_Core_Block_Template
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
        $collection = $this->getDesigner()->getMediaGalleryImages();
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
        $params = array('id' => $this->getDesigner()->getId());
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
    public function getDesigner()
    {
        if (!Mage::registry('current_designer')) {
            $designerId  = (int) $this->getRequest()->getParam('id');
            $designer = Mage::getModel('validoc_designer/designer')->load($designerId);
            Mage::register('current_designer', $designer);
        }
        return Mage::registry('current_designer');
    }

    public function getImageLabel($designer = null, $mediaAttributeCode = 'image')
    {
        if (is_null($designer)) {
            $designer = $this->getDesigner();
        }

        $label = $designer->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $designer->getName();
        }

        return $label;
    }
}
