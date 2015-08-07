<?php 
class Validoc_Floorplan_Model_Resource_Floorplan_Product_Collection
    extends Mage_Catalog_Model_Resource_Product_Collection {
    protected $_joinedFields = false;
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('validoc_floorplan/floorplan_product')),
                'related.product_id = e.entity_id',
                array('position', 'quantity')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    public function addFloorplanFilter($floorplan){
        if ($floorplan instanceof Validoc_Floorplan_Model_Floorplan){
            $floorplan = $floorplan->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.floorplan_id = ?', $floorplan);
        return $this;
    }
}
