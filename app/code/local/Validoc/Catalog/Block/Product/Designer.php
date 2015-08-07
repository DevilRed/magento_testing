<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 13-08-14
 * Time: 12:47 PM
 */
class Validoc_Catalog_Block_Product_Designer extends Mage_Catalog_Block_Product_View {

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return Validoc_Designer_Model_Designer
     */
    public function getDesigners()
    {
        $product = $this->getProduct();
        $board_ids = explode(',', $product->getData('board_id'));
        //Mage::log($board_ids);
        $boardCollection = Mage::getModel('validoc_board/board')->getCollection();
        $boardCollection->addFieldToSelect('*');
        $boardCollection->addFieldToFilter('board_id', array(
            'in' => array('finset' => $board_ids)
        ));
        $collection_designer = new Varien_Data_Collection();
        foreach($boardCollection as $board) {
            $id_designer = $board->getDesignerId();
            if(!$this->existDesigner($collection_designer,$id_designer)){
                $collection_designer->addItem(Mage::getModel('validoc_designer/designer')->load($id_designer));
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