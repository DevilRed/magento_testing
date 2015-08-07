<?php
class Validoc_Floorplan_Block_View extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('floorplan_list');
    }
}
