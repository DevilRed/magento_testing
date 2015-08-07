<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 20-08-14
 * Time: 12:00 PM
 */
class Validoc_Fabric_Block_Board_Related extends Mage_Core_Block_Template
{
    public function getFabric() {
        return Mage::registry('current_fabric');
    }
    public function getBoards(){
        $fabric = $this->getFabric();

        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect("*");
        $collection->addAttributeToFilter("fabric_id", array('eq' => $fabric->getId()));
        $board_ids = array();
        foreach($collection as $_product){
            $B = explode(',',$_product->getBoardId());
            for($i=0; $i < count($B); $i++){
                if(!in_array($B[$i],$board_ids)){
                    $board_ids[]=$B[$i];
                }
            }
        }
        $boardCollection = new Varien_Data_Collection();
        if(isset($board_ids) && count($board_ids) > 0){
            Mage::register('current_boardIds', $board_ids);
            $boardCollection = Mage::getModel('validoc_board/board')->getCollection();
            $boardCollection->addFieldToSelect('*');
            $boardCollection->addFieldToFilter('board_id', array(
                'in' => array('finset' => $board_ids)
            ));
        }

        return $boardCollection;
    }

}