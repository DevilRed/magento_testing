<?php
/**
 * Created by PhpStorm.
 * User: JHONNY-PC
 * Date: 14-08-14
 * Time: 01:47 PM
 */
class Validoc_Fabric_Block_List extends Mage_Core_Block_Template
{
    /**
     * Fabric amount per row depending on custom page layout of category
     *
     * @var array
     */
    protected $_columnCountLayoutDepend = array();

    /**
     * Default toolbar block name
     *
     * @var string
     */
    protected $_defaultToolbarBlock = 'catalog/product_list_toolbar';

    /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_fabricCollection;

    /**
     * Default product amount per row
     *
     * @var int
     */
    protected $_defaultColumnCount = 3;


    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getFabricCollection()
    {
        if (is_null($this->_fabricCollection) || TRUE) {
            $fabricType = Mage::registry('fabricType');//for group filter from nav
            $type_id = Mage::registry('type_id');//for get a single item
            if($fabricType == 'all'){
                $this->_fabricCollection = Mage::getModel('validoc_fabric/fabric')->getCollection();
            }else if($fabricType == 'source'){
                if(isset($type_id)){
                    $this->_fabricCollection = Mage::getModel('validoc_fabric/fabric')
                                ->getCollection()
                                ->addFieldToFilter('manufacturer', $type_id)
                                ->setOrder('manufacturer', 'desc')
                                ->setOrder('name', 'desc');
                }else{
                    $this->_fabricCollection = Mage::getModel('validoc_fabric/fabric')
                                ->getCollection()
                                ->setOrder('manufacturer', 'desc')
                                ->setOrder('name', 'desc');
                }
            }else if($fabricType == 'color'){
                if(isset($type_id)){
                    $this->_fabricCollection = Mage::getModel('validoc_fabric/fabric')->getCollection()
                                ->addFieldToFilter('color', array('finset' => $type_id))
                                ->setOrder('color', 'desc')
                                ->setOrder('name', 'desc');
                }else{
                    $this->_fabricCollection = Mage::getModel('validoc_fabric/fabric')->getCollection()
                                ->setOrder('color', 'desc')
                                ->setOrder('name', 'desc');
                }
            }
        }

        return $this->_fabricCollection;
    }

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedFabricCollection()
    {
        return $this->_getFabricCollection();
    }

    /**
     * Retrieve current view mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->getChild('toolbar')->getCurrentMode();
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     */
    protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();

        // called prepare sortable parameters
        $collection = $this->_getFabricCollection();

        // use sortable parameters
        if ($orders = $this->getAvailableOrders()) {
            $toolbar->setAvailableOrders($orders);
        }
        if ($sort = $this->getSortBy()) {
            $toolbar->setDefaultOrder($sort);
        }
        if ($dir = $this->getDefaultDirection()) {
            $toolbar->setDefaultDirection($dir);
        }
        if ($modes = $this->getModes()) {
            $toolbar->setModes($modes);
        }

        // set collection to toolbar and apply sort
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);

        $this->_getFabricCollection()->load();

        return parent::_beforeToHtml();
    }


    public function getToolbarBlock()
    {
        if ($blockName = $this->getToolbarBlockName()) {
            if ($block = $this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());
        return $block;
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    public function setCollection($collection)
    {
        $this->_fabricCollection = $collection;
        return $this;
    }

    public function addField($code)
    {
        $this->_getFabricCollection()->addFieldToSelect($code);
        return $this;
    }

    /**
     * Prepare Sort By fields from Category Data
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Block_Product_List
     */
    public function prepareSortableFieldsByCategory($category) {
        if (!$this->getAvailableOrders()) {
            $this->setAvailableOrders($category->getAvailableSortByOptions());
        }
        $availableOrders = $this->getAvailableOrders();
        if (!$this->getSortBy()) {
            if ($categorySortBy = $category->getDefaultSortBy()) {
                if (!$availableOrders) {
                    $availableOrders = $this->_getConfig()->getAttributeUsedForSortByArray();
                }
                if (isset($availableOrders[$categorySortBy])) {
                    $this->setSortBy($categorySortBy);
                }
            }
        }

        return $this;
    }

    /**
     * Add row size depends on page layout
     *
     * @param string $pageLayout
     * @param int $columnCount
     * @return Mage_Catalog_Block_Product_List
     */
    public function addColumnCountLayoutDepend($pageLayout, $columnCount)
    {
        $this->_columnCountLayoutDepend[$pageLayout] = $columnCount;
        return $this;
    }

    /**
     * Retrieve row size depends on page layout
     *
     * @param string $pageLayout
     * @return int|boolean
     */
    public function getColumnCountLayoutDepend($pageLayout)
    {
        if (isset($this->_columnCountLayoutDepend[$pageLayout])) {
            return $this->_columnCountLayoutDepend[$pageLayout];
        }

        return false;
    }

    /**
     * Retrieve product amount per row
     *
     * @return int
     */
    public function getColumnCount()
    {
        if (!$this->_getData('column_count')) {
            $pageLayout = $this->getPageLayout();
            if ($pageLayout && $this->getColumnCountLayoutDepend($pageLayout->getCode())) {
                $this->setData(
                    'column_count',
                    $this->getColumnCountLayoutDepend($pageLayout->getCode())
                );
            } else {
                $this->setData('column_count', $this->_defaultColumnCount);
            }
        }

        return (int) $this->_getData('column_count');
    }

    /**
     * Retrieve current page layout
     *
     * @return Varien_Object
     */
    public function getPageLayout()
    {
        return $this->helper('page/layout')->getCurrentPageLayout();
    }

    public function getFabricAttributtes($type, $type_id = null){
        if($type == 'color'){
            $colors = array();
            $attributeModel = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color');
            $allOptions = $attributeModel->getSource()->getAllOptions(true, true);
            foreach ($allOptions as $instance) {
                $colors[$instance['value']] = $instance['label'];
            }
            return $colors;
        }else if($type == 'source'){
            $sources = array();
            $attributeModel = Mage::getModel('eav/config')->getAttribute('catalog_product', 'manufacturer');
            $allOptions = $attributeModel->getSource()->getAllOptions(true, true);
            foreach ($allOptions as $instance) {
                $sources[$instance['value']] = $instance['label'];
            }
            return $sources;
        }
    }

    public function getFabricSource($optionId = null){
        $attr = Mage::getModel('eav/entity_attribute_option')
                                ->getCollection()->setStoreFilter()
                                ->join('attribute','attribute.attribute_id=main_table.attribute_id', 'attribute_code')

        ->addFieldToFilter('main_table.option_id',array('eq'=>$optionId))->getFirstItem();
        return $attr->getValue();
    }
}