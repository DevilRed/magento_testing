<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 5/29/2015
 * Time: 12:59 PM
 */ 
class Validoc_Catalog_Block_Category_View extends Mage_Catalog_Block_Category_View
{
    /**
     * Check if category display mode is "Subcategoires"
     * @return bool
     */
    public function isSubcategoriesMode()
    {
        return $this->getCurrentCategory()->getDisplayMode()==Validoc_Catalog_Model_Category::DM_SUBCATEGORIES;
    }

    public function getSubcategoriesHtml()
    {
        if (!$this->getData('subcategories_block_html')) {
            $html = $this->getLayout()->createBlock('catalog/navigation')
                ->setColumnCount('3')
                ->setTemplate('catalog/navigation/room_list.phtml')
                ->toHtml();
            $this->setData('subcategories_block_html', $html);
        }

        return $this->getData('subcategories_block_html');
    }

    /**
     * Check if category display mode is "Subcategoires"
     * @return bool
     */
    public function isBoardsMode()
    {
        return $this->getCurrentCategory()->getDisplayMode()==Validoc_Catalog_Model_Category::DM_BOARDS;
    }

    public function getBoardsHtml()
    {
        if (!$this->getData('boards_block_html')) {
            $html = $this->getLayout()->createBlock('catalog/navigation')
                ->setColumnCount('3')
                ->setTemplate('catalog/navigation/board_list.phtml')
                ->toHtml();
            $this->setData('subcategories_block_html', $html);
        }

        return $this->getData('subcategories_block_html');
    }
}