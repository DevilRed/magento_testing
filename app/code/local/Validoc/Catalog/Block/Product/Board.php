<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 13-08-14
 * Time: 11:51 PM
 */
class Validoc_Catalog_Block_Product_Board extends Mage_Catalog_Block_Product_View
{

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getBoards()
    {
        $product = $this->getProduct();
        $board_ids = explode(',', $product->getData('board_id'));

        $boardCollection = Mage::getModel('validoc_board/board')->getCollection();
        $boardCollection->addFieldToSelect('*');
        $boardCollection->addFieldToFilter('board_id', array(
            'in' => array('finset' => $board_ids)
        ));

        return $boardCollection;
    }
}