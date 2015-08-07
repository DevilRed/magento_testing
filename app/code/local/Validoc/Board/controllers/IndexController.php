<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/23/14
 * Time: 1:03 AM
 */
class Validoc_Board_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {

        $this->_redirect('*/board/list');
    }
}