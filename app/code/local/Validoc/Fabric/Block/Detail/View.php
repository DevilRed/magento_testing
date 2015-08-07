<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 20-08-14
 * Time: 11:45 AM
 */
class Validoc_Fabric_Block_Detail_View extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * Retrieve current designer model
     *
     * @return Validoc_Fabric_Model_Fabric
     */
    public function getFabric()
    {
        if (!Mage::registry('current_fabric')) {
            $fabricId  = (int) $this->getRequest()->getParam('id');
            $fabric = Mage::getModel('validoc_fabric/fabric')->load($fabricId);
            Mage::register('current_fabric', $fabric);
        }
        return Mage::registry('current_fabric');
    }

}