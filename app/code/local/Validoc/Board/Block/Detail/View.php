<?php

class Validoc_Board_Block_Detail_View extends Mage_Core_Block_Template
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
     * Retrieve current board model
     *
     * @return Validoc_Board_Model_Board
     */
    public function getBoard()
    {
        if (!Mage::registry('current_board')) {
            $boardId  = (int) $this->getRequest()->getParam('id');
            $board = Mage::getModel('validoc_board/board')->load($boardId);
            Mage::register('current_board', $board);
        }
        return Mage::registry('current_board');
    }

    /**
     * @return Validoc_Designer_Model_Designer
     */
    public function getDesigner()
    {
        $board = $this->getBoard();
        $designer = $board->getDesigner();

        return $designer;
    }
}
