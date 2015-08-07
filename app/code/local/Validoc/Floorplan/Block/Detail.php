<?php
class Validoc_Floorplan_Block_Detail extends Mage_Core_Block_Template
{
    public function getDesignerFloorplan() {

        $temp = Mage::registry('id');
        $floorplan = Mage::getModel("validoc_floorplan/floorplan")->load($temp);

        return $floorplan;
    }
}
