<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 5/11/2015
 * Time: 5:46 PM
 */ 
class Validoc_Catalog_Model_Category extends Mage_Catalog_Model_Category
{
    /**
     * New Display Mode.
     * Can display only categories children
     */
    const DM_SUBCATEGORIES            = 'SUBCATEGORIES';
    const DM_BOARDS            = 'BOARDS';

    /**
     * Get category products collection
     *
     * @return Varien_Data_Collection_Db
     */
    public function getBoardsCollection()
    {
        $collection = Mage::getResourceModel('validoc_board/board_collection')
            ->addCategoryFilter($this);
        return $collection;
    }
}