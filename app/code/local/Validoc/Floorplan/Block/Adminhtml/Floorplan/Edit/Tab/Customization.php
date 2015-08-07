<?php
	class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit_Tab_Customization extends Mage_Adminhtml_Block_Widget_Form{
		public function __construct(){
			parent::__construct();
			$this->setTemplate('validoc/floorplan/edit/tab/gridcustomization.phtml');
		}
		public function getProducts($floorplanId){
			$model = Mage::getModel('validoc_floorplan/floorplan');
			$floorplan = $model->load($floorplanId);
			$productsData = $floorplan->getSelectedProducts();
			$floorplanProducts = array();
			foreach ($productsData as $product) {
				$floorplanProducts[$product->_data["entity_id"]] = $product->_data["quantity"];
				//var_dump($product);
			}
			$productsId = array();
			foreach ($floorplanProducts as $id => $qty) {
				array_push($productsId, $id);
			}
			$attributes = Mage::getSingleton('catalog/config')->getProductAttributes();
			$_productCollection = Mage::getModel('catalog/product')
										->getCollection()
										->addAttributeToSort('created_at', 'DESC')
				                        ->addAttributeToFilter('entity_id',  array('in' => $productsId))
				                        ->addAttributeToSelect($attributes)
				                        ->load();
			return $_productCollection;
		}
		public function getGrid($floorplanId){
			$model = Mage::getModel('validoc_floorplan/floorplan');
			$floorplan = $model->load($floorplanId);
			return $floorplan->getSerializedGrid();
		}
	}