<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/9/14
 * Time: 10:57 AM
 */ 
class Validoc_Board_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_ROOT = 'board/list/route';

    public function conf($code, $store = null)
    {
        return Mage::getStoreConfig($code, $store);
    }

    public function getRoute($store = null)
    {
        $route = trim($this->conf(self::XML_ROOT));
        if (!$route) {
            $route = self::DEFAULT_ROOT;
        }
        return $route;
    }

    public function getRouteUrl($store = null)
    {
        return Mage::getUrl($this->getRoute($store), array('_store' => $store));

    }
}