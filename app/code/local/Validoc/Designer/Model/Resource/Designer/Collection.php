<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 2:56 PM
 */ 
class Validoc_Designer_Model_Resource_Designer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('validoc_designer/designer');
    }

}