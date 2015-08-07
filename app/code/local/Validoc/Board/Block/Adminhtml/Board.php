<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Board_Block_Adminhtml_Board extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Initialize grid container settings
     * The child grid block class will be:
     * $this->_blockGroup . '/' . $this->_controller . '_grid'
     * i.e. training/adminhtml_ship_grid
     */
    protected function _construct() {
        $this->_blockGroup = 'validoc_board'; //alias module
        $this->_controller = 'adminhtml_board';
        $this->_headerText = 'Manage Rooms';
        parent::_construct();
    }
}