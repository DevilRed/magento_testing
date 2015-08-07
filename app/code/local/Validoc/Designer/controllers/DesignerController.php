<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/23/14
 * Time: 1:03 AM
 */
class Validoc_Designer_DesignerController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->_redirect('*/*/list');
    }

    public function listAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction() {
        if ($designerId = $this->getRequest()->getParam('id', false)) {
            $designer = Mage::getModel('validoc_designer/designer')->load($designerId);
            Mage::register('current_designer', $designer);
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}