<?php
class Validoc_Floorplan_FloorplanController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->_redirect('*/*/list');
    }

    public function listAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction() {
        if ($floorplanId = $this->getRequest()->getParam('id', false)) {
            $floorplan = Mage::getModel('validoc_floorplan/floorplan')->load($floorplanId);
            Mage::register('current_floorplan', $floorplan);
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function addmultipleAction(){
        $requestedProducts = $this->getRequest()->getParam('products_requested');

        $requestedProducts = json_decode($requestedProducts);
        try{
            $cart = Mage::helper('checkout/cart')->getCart();
            foreach ($requestedProducts as $id => $qty) {
                $params = array('qty' => $qty);
                $product = Mage::getModel('catalog/product')->load($id);
                $cart->addProduct($product, $params);
            }
            $cart->save();
            $jsonResponse = array('msg' => 'products were added');
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        } catch(Exception $e){
            $jsonResponse = array('msg' => $e->getMessage());
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        }
    }
}
