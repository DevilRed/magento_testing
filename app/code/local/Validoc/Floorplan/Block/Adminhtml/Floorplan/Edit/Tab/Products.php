<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit_Tab_Products extends Mage_Adminhtml_Block_Catalog_Category_Tree{
    protected $products;

    public function __construct(){
        parent::__construct();
	$data = Mage::registry('current_floorplan')->toArray();
	$this->products  = unserialize($data["content"]);
        $this->setTemplate('validoc/floorplan/edit/tab/products.phtml');
    }
}
