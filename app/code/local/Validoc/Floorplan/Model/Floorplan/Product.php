<?php
class Validoc_Floorplan_Model_Floorplan_Product
    extends Mage_Core_Model_Abstract {
    protected function _construct(){
        $this->_init('validoc_floorplan/floorplan_product');
    }
    public function saveFloorplanRelation($floorplan){
        $data = $floorplan->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveFloorplanRelation($floorplan, $data);
        }
        return $this;
    }
    public function getProductCollection($floorplan){
        $collection = Mage::getResourceModel('validoc_floorplan/floorplan_product_collection')
            ->addFloorplanFilter($floorplan);
        return $collection;
    }
}
