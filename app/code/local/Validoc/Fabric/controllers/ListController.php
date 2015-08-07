<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 14-08-14
 * Time: 11:40 AM
 */
class Validoc_Fabric_ListController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}