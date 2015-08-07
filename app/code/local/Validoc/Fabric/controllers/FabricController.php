<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 15-08-14
 * Time: 11:01 AM
 */
class Validoc_Fabric_FabricController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $type = $_GET['type'];
        $this->_redirect('*/*/list', array('type' => $type));
    }

    public function listAction() {
        $type = $this->getRequest()->getParam('type');
        $type_id = $this->getRequest()->getParam('type_id');
        if(isset($type_id)){
            Mage::register('type_id', $type_id);
        }
        Mage::register('fabricType', $type);
        $this->loadLayout();
        $this->renderLayout();

    }

    public function viewAction() {
        if ($fabricId = $this->getRequest()->getParam('id', false)) {
            $fabric = Mage::getModel('validoc_fabric/fabric')->load($fabricId);
            Mage::register('current_fabric', $fabric);
        }else{
            $this->_redirect('*/*/list');
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}