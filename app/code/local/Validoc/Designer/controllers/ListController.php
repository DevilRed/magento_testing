<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 08-08-14
 * Time: 03:30 PM
 */
class Validoc_Designer_ListController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}