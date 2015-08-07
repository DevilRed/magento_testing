<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Initialize grid container settings
     * The child grid block class will be:
     * $this->_blockGroup . '/' . $this->_controller . '_grid'
     * i.e. training/adminhtml_ship_grid
     */
    protected function _construct() {
        $this->_blockGroup = 'validoc_floorplan'; //alias module
        $this->_controller = 'adminhtml_floorplan';
        $this->_headerText = 'Floorplans';
        parent::_construct();
    }
}
