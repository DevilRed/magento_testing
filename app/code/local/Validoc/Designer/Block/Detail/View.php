<?php

class Validoc_Designer_Block_Detail_View extends Mage_Core_Block_Template
{
    /**
     * Add meta information from product to head block
     *
     * @return Mage_Catalog_Block_Product_View
     */
    protected function _prepareLayout()
    {
//        $this->getLayout()->createBlock('catalog/breadcrumbs');
//        $headBlock = $this->getLayout()->getBlock('head');
//        if ($headBlock) {
//            $product = $this->getProduct();
//            $title = $product->getMetaTitle();
//            if ($title) {
//                $headBlock->setTitle($title);
//            }
//            $keyword = $product->getMetaKeyword();
//            $currentCategory = Mage::registry('current_category');
//            if ($keyword) {
//                $headBlock->setKeywords($keyword);
//            } elseif ($currentCategory) {
//                $headBlock->setKeywords($product->getName());
//            }
//            $description = $product->getMetaDescription();
//            if ($description) {
//                $headBlock->setDescription( ($description) );
//            } else {
//                $headBlock->setDescription(Mage::helper('core/string')->substr($product->getDescription(), 0, 255));
//            }
//            if ($this->helper('catalog/product')->canUseCanonicalTag()) {
//                $params = array('_ignore_category' => true);
//                $headBlock->addLinkRel('canonical', $product->getUrlModel()->getUrl($product, $params));
//            }
//        }

        return parent::_prepareLayout();
    }

    /**
     * Retrieve current designer model
     *
     * @return Validoc_Designer_Model_Designer
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
    public function getBoards(){
        $designerId  = (int) $this->getRequest()->getParam('id');

        $boardsCollection = Mage::getModel('validoc_board/board')->getCollection();
        $boardsCollection->addFieldToSelect('*');
        $boardsCollection->addFieldToFilter('designer_id', $designerId);
        return $boardsCollection;
    }
    public function getBiographyImages(){
        $collection = $this->getDesigner()->getMediaGalleryImages();
        return $collection;
    }
}
