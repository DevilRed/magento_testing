<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/23/14
 * Time: 3:38 PM
 */
class Validoc_Board_Block_View extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

//        $this->getLayout()->createBlock('catalog/breadcrumbs');
//
//        if ($headBlock = $this->getLayout()->getBlock('head')) {
//            $category = $this->getCurrentCategory();
//            if ($title = $category->getMetaTitle()) {
//                $headBlock->setTitle($title);
//            }
//            if ($description = $category->getMetaDescription()) {
//                $headBlock->setDescription($description);
//            }
//            if ($keywords = $category->getMetaKeywords()) {
//                $headBlock->setKeywords($keywords);
//            }
//            if ($this->helper('catalog/category')->canUseCanonicalTag()) {
//                $headBlock->addLinkRel('canonical', $category->getUrl());
//            }
//            /*
//            want to show rss feed in the url
//            */
//            if ($this->IsRssCatalogEnable() && $this->IsTopCategory()) {
//                $title = $this->helper('rss')->__('%s RSS Feed',$this->getCurrentCategory()->getName());
//                $headBlock->addItem('rss', $this->getRssLink(), 'title="'.$title.'"');
//            }
//        }

        return $this;
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('board_list');
    }


}
