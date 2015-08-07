<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 20-08-14
 * Time: 04:16 PM
 */

class Validoc_Fabric_Block_Designer_Related extends Mage_Core_Block_Template
{
    public function getDesigners() {
        /*$boardsCollection = Mage::getModel('validoc_designer/designer')->getCollection();
        return $boardsCollection;*/
        $collection_designer = new Varien_Data_Collection();
        $board_ids =Mage::registry('current_boardIds');
        if(isset($board_ids)){
            $boardCollection = Mage::getModel('validoc_board/board')->getCollection();
            $boardCollection->addFieldToSelect('*');
            $boardCollection->addFieldToFilter('board_id', array(
                'in' => array('finset' => $board_ids)
            ));
            foreach($boardCollection as $board) {
                $id_designer = $board->getDesignerId();
                if(!$this->existDesigner($collection_designer,$id_designer)){
                    $collection_designer->addItem(Mage::getModel('validoc_designer/designer')->load($id_designer));
                }
            }
        }

        return $collection_designer;
    }
    private function existDesigner($data,$id){
        foreach($data as $designer)
        {
            if($designer->getData('designer_id')== $id)
                return true;
        }
        return false;
    }
}