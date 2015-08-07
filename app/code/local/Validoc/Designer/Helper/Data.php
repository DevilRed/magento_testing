<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 8/9/14
 * Time: 11:00 AM
 */ 
class Validoc_Designer_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function parseUrl($url){
        $parse = parse_url($url);
        return $parse['host']; // prints 'google.com'
    }
}