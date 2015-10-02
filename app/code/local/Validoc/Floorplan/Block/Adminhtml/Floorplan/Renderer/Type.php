<?php
	class Validoc_Floorplan_Block_Adminhtml_Floorplan_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
		public function render(Varien_Object $row){
			$prod = Mage::getModel('catalog/product')->load($row->getEntityId());
			$roomCode = $prod->getRoomCode();
			return $roomCode;
		}
	}