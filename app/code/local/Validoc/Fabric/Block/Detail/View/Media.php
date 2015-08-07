<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 20-08-14
 * Time: 11:52 AM
 */
class Validoc_Fabric_Block_Detail_View_Media extends Mage_Core_Block_Template
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
        $collection = $this->getFabric()->getMediaGalleryImages();
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
        $params = array('id' => $this->getFabric()->getId());
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
    public function getFabric()
    {
        if (!Mage::registry('current_fabric')) {
            $fabricId  = (int) $this->getRequest()->getParam('id');
            $fabric = Mage::getModel('validoc_designer/designer')->load($fabricId);
            Mage::register('current_designer', $fabric);
        }
        return Mage::registry('current_fabric');
    }

    public function getImageLabel($fabric = null, $mediaAttributeCode = 'image')
    {
        if (is_null($fabric)) {
            $fabric = $this->getDesigner();
        }

        $label = $fabric->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $fabric->getName();
        }

        return $label;
    }
}