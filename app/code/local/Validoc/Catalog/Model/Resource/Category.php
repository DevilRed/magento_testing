<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 5/8/2015
 * Time: 1:05 PM
 */ 
class Validoc_Catalog_Model_Resource_Category extends Mage_Catalog_Model_Resource_Category
{
    /**
     * Return parent categories of category
     *
     * @param Mage_Catalog_Model_Category $category
     * @return array
     */
    public function getParentCategories($category)
    {
        $pathIds = array_reverse(explode(',', $category->getPathInStore()));
        $categories = Mage::getResourceModel('catalog/category_collection')
            ->setStore(Mage::app()->getStore())
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('name_suffix')
            ->addAttributeToSelect('url_key')
            ->addFieldToFilter('entity_id', array('in' => $pathIds))
            ->addFieldToFilter('is_active', 1)
            ->load()
            ->getItems();
        return $categories;
    }
}