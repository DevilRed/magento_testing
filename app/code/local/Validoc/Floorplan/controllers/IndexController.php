<?php
class Validoc_Floorplan_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {

        $this->_redirect('*/floorplan/list');
    }
}
