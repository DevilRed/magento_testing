<?php
	class Validoc_Board_Block_Adminhtml_Board_Edit_Tab_Customization extends Mage_Adminhtml_Block_Widget_Form{
		public function __construct(){
			parent::__construct();
			$this->setTemplate('validoc/board/edit/tab/gridcustomization.phtml');
		}
		public function getProducts($boardId){
			$model = Mage::getModel('validoc_board/board');
			$board = $model->load($boardId);
			$floorplans = $board->getFloorPlans($boardId);
			$floorplanProducts = array();
			foreach ($floorplans as $fp) {
				$fpInstance = Mage::getModel('validoc_floorplan/floorplan')->load($fp->getFloorplanId());
				$fpProducts = $fpInstance->getSelectedProducts();
				foreach ($fpProducts as $p) {
					if(!isset($floorplanProducts[$p->_data["entity_id"]]))
					    $floorplanProducts[$p->_data["entity_id"]] = $p->_data["quantity"];
				}
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


			if($board->getType() == 2){//if type is decor vignettes
				$catIds = $model->getCustomCategoriesId($this->getBoard()->getId());
				if(!empty($catIds)){
				    $ctf = array();//categories to filter
				    foreach ($catIds as $k => $cat) {
				        $ctf[]['finset'] = $cat;
				    }
				}
				$_productCollection = Mage::getModel('catalog/product')
				                    ->getCollection()
				                    ->addAttributeToSelect('*')
				                    ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
				                    ->addAttributeToFilter('category_id', array($ctf))
				                    ->addAttributeToSort('created_at', 'DESC')
				                    ->load();
			}
			return $_productCollection;
		}
		public function getGrid($boardId){
			$model = Mage::getModel('validoc_board/board');
			$board = $model->load($boardId);
			return $board->getSerializedGrid();
		}
		public function getBoard()
		{
		    if (!Mage::registry('current_board')) {
		        $boardId  = (int) $this->getRequest()->getParam('id');
		        $board = Mage::getModel('validoc_board/board')->load($boardId);
		        Mage::register('current_board', $board);
		    }
		    return Mage::registry('current_board');
		}
	}