<?php
	class Validoc_Board_Block_Adminhtml_Board_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
		public function render(Varien_Object $row){
			$value = $row->getData($this->getColumn()->getIndex());
			if($value == 1){
				return 'Sitting Rooms';
			}else if($value == 2){
				return 'Decor Vignettes';
			}else{
				return 'Not Specified';
			}
		}
	}