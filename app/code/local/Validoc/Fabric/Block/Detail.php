<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 20-08-14
 * Time: 11:26 AM
 */
class Validoc_Fabric_Block_Detail extends Mage_Core_Block_Template
{
    public function getFabricDetail() {

        $temp = Mage::registry('id');
        $fabric = Mage::getModel("validoc_fabric/fabric")->load($temp);

        return $fabric;
    }
}