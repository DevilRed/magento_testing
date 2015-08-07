<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 23-07-14
 * Time: 03:31 AM
 */
class Validoc_Designer_Block_Detail extends Mage_Core_Block_Template
{
    public function getDesignerBoard() {

        $temp = Mage::registry('id');
        $board = Mage::getModel("validoc_designer/designer")->load($temp);

        return $board;
    }
}