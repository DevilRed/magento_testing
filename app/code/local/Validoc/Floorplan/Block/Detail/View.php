<?php

class Validoc_Floorplan_Block_Detail_View extends Mage_Core_Block_Template
{
    /**
     * Add meta information from product to head block
     *
     * @return Mage_Catalog_Block_Product_View
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * Retrieve current floorplan model
     *
     * @return Validoc_Floorplan_Model_Floorplan
     */
    public function getFloorplan()
    {
        if (!Mage::registry('current_floorplan')) {
            $floorplanId  = (int) $this->getRequest()->getParam('id');
            $floorplan = Mage::getModel('validoc_floorplan/floorplan')->load($floorplanId);
            Mage::register('current_floorplan', $floorplan);
        }
        return Mage::registry('current_floorplan');
    }

    /**
     * @return Validoc_Designer_Model_Designer
     */
    public function getDesigner()
    {
        $floorplan = $this->getFloorplan();
        $boardId = $floorplan->getBoardId();
        $boardModel = Mage::getModel('validoc_board/board')->load($boardId);
        $designerBoard = $boardModel->getDesigner();

        return $designerBoard;
    }
    public function getBoard(){
        if (!Mage::registry('current_board')) {
            $floorplan = $this->getFloorplan();
            $boardId  = $floorplan->getBoardId();
            $board = Mage::getModel('validoc_board/board')->load($boardId);
            Mage::register('current_board', $board);
        }
        return Mage::registry('current_board');
    }
    public function getFloorplanProducts(){
        if (!Mage::registry('current_floorplan_products')) {
	    $a = Mage::getModel('validoc_floorplan/floorplan')->load($this->getRequest()->getParam('id'));
	    $products = array();
	    foreach($a->getSelectedProducts() as $p){
		$products[$p->_data["entity_id"]] = $p->_data["quantity"];
	    }
            Mage::register('current_floorplan_products', $products);
        }
        return Mage::registry('current_floorplan_products');
    }
    public function getProductNumber($fpId, $prodId){
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "SELECT position FROM validoc_floorplan_product WHERE floorplan_id = $fpId AND product_id = $prodId";
        $row = $connection->fetchAll($sql);
        return $row;
    }
}
