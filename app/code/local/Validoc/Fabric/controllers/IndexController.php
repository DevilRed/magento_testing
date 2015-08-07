<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 14-08-14
 * Time: 11:37 AM
 */
class Validoc_Fabric_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
        //echo "Hola";
        $this->_redirect('*/fabric/list');
    }
}