<?php

class Validoc_Catalog_Model_Attribute_Source_Board extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $collection = Mage::getModel('validoc_board/board')->getCollection();

        $options = array();
        foreach ($collection as $model) {
            $option = array('value' => $model->getId(),'label' => $model->getName());
            $options[] = $option;
        }

        return $options;
    }
}