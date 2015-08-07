<?php
class Validoc_Floorplan_Model_Resource_Floorplan_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Alias for main table
     */
    const MAIN_TABLE_ALIAS = 'e';

    protected function _construct()
    {
        $this->_init('validoc_floorplan/floorplan');
    }

    /**
     * Initialize collection select
     * Redeclared for remove entity_type_id condition
     * in catalog_product_entity we store just products
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
//    protected function _initSelect()
//    {
//        $this->getSelect()->from(array(self::MAIN_TABLE_ALIAS => $this->getTable('validoc_floorplan/floorplan')));
//        return $this;
//    }

    /**
     * Specify category filter for product collection
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Validoc_Floorplan_Model_Resource_Floorplan_Collection
     */
    public function addCategoryFilter(Mage_Catalog_Model_Category $category)
    {
        $this->_applyZeroStoreFloorplanLimitations($category);

        return $this;
    }

    /**
     * Apply limitation filters to collection base on API
     * Method allows using one time category product table
     * for combinations of category_id filter states
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _applyZeroStoreFloorplanLimitations($category)
    {
        $conditions = array(
            'cat_floorplan.floorplan_id=main_table.floorplan_id',
            $this->getConnection()->quoteInto('cat_floorplan.category_id=?', $category->getId())
        );
        $joinCond = join(' AND ', $conditions);


        $this->getSelect()->join(
            array('cat_floorplan' => $this->getTable('validoc_floorplan/floorplan_category')),
            $joinCond,
            array('cat_index_position' => 'position')
        );

        Mage::log($this->getSelect()->__toString());

        $this->_joinFields['position'] = array(
            'table' => 'cat_floorplan',
            'field' => 'position',
        );

        return $this;
    }
}
