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
}
