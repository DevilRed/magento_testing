<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/4/14
 * Time: 9:24 AM
 */
class Validoc_Designer_Block_Board_Related extends Mage_Catalog_Block_Product_Abstract
{
    public function getDesigner() {
        return Mage::registry('current_designer');
    }

    public function getBoards() {
        $designer = $this->getDesigner();

        $boardsCollection = Mage::getModel('validoc_board/board')->getCollection();
        $boardsCollection->addFieldToSelect('*');
        $boardsCollection->addFieldToFilter('designer_id', $designer->getId());


        return $boardsCollection;
    }

}