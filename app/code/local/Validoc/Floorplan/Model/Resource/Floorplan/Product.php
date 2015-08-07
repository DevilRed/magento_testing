<?php
class Validoc_Floorplan_Model_Resource_Floorplan_Product
    extends Mage_Core_Model_Resource_Db_Abstract {
    protected function  _construct(){
        $this->_init('validoc_floorplan/floorplan_product', 'rel_id');
    }
    public function saveFloorplanRelation($floorplan, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('floorplan_id=?', $floorplan->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
	    $qty = @$info['quantity'];
	    if($qty == 0) $qty = 1;
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'floorplan_id'      => $floorplan->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position'],
		'quantity'      => $qty
            ));
        }
        return $this;
    }
}
