<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/23/14
 * Time: 1:03 AM
 */
class Validoc_Board_BoardController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->_redirect('*/*/list');
    }

    public function listAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction() {
        if ($boardId = $this->getRequest()->getParam('id', false)) {
            $board = Mage::getModel('validoc_board/board')->load($boardId);
            Mage::register('current_board', $board);
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}