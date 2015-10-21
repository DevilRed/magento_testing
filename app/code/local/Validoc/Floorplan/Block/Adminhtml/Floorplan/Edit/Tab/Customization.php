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
				$floorplanProducts[$product->_data["entity_id"]] = array('quantity' => $product->_data["quantity"], 'position' => $product->_data['position']);
				//var_dump($product);
			}
			//reorder array based on position
			$floorplanProducts = $this->orderBy($floorplanProducts, 'position');

			$productsId = array();
			foreach ($floorplanProducts as $id => $qty) {
				array_push($productsId, $id);
			}
			$orderString = array('CASE e.entity_id');
			foreach($productsId as $i => $productId){
				$orderString[] = 'WHEN '.$productId.' THEN '.$i;
			}
			$orderString[] = ' END';
			$orderString = implode(' ', $orderString);
			$attributes = Mage::getSingleton('catalog/config')->getProductAttributes();
			$_productCollection = Mage::getModel('catalog/product')
										->getCollection()
										/*->addAttributeToSort('created_at', 'DESC')*/
				                        ->addAttributeToFilter('entity_id',  array('in' => $productsId))
				                        ->addAttributeToSelect($attributes);
				                        //->load();
			$_productCollection->getSelect()->order(new Zend_Db_Expr($orderString));
			$_productCollection->load();
			return $_productCollection;
		}
		public function getGrid($floorplanId){
			$model = Mage::getModel('validoc_floorplan/floorplan');
			$floorplan = $model->load($floorplanId);
			return $floorplan->getSerializedGrid();
		}
		private function orderBy($data, $field){
			$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
			uasort($data, create_function('$a,$b', $code));

			return $data;
		}
	}