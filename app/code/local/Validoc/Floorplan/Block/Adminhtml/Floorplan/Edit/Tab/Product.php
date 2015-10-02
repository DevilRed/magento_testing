<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Edit_Tab_Product
    extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct(){
        parent::__construct();
        $this->setId('product_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getFloorplan()->getId()) {
            $this->setDefaultFilter(array('in_products'=>1));
        }
    }
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect('price');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection->joinAttribute('product_name', 'catalog_product/name', 'entity_id', null, 'left', $adminStore);
        if ($this->getFloorplan()->getId()){
            $constraint = '{{table}}.floorplan_id='.$this->getFloorplan()->getId();
        }
        else{
            $constraint = '{{table}}.floorplan_id=0';
        }
        $collection->joinField('position',
            'validoc_floorplan/floorplan_product',
            'position',
            'product_id=entity_id',
            $constraint,
            'left');
        /*$collection->joinAttribute(
            'room_code',
            'catalog_product/entity_varchar',
            'entity_id',
            null,
            'inner',
            $adminStore
        );*/
        //$collection->addAttributeToFilter('room_code', 'value');
        $collection->addAttributeToSelect('room_code');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
     protected function _prepareMassaction(){
        return $this;
    }
    protected function _prepareColumns(){
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_products',
            'values'=> $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'entity_id'
        ));
	$this->addColumn('quantity', array(
            'header'=> Mage::helper('catalog')->__('Quantity'),
	    'name'  => 'quantity',
            'align' => 'left',
            'index' => 'quantity',
	    'width' => 60,
            'type'  => 'number',
	    'validate_class'=> 'validate-number',
	    'editable' => true,
        ));
        $this->addColumn('product_name', array(
            'header'=> Mage::helper('catalog')->__('Name'),
            'align' => 'left',
            'index' => 'product_name',
        ));
        $this->addColumn('sku', array(
            'header'=> Mage::helper('catalog')->__('SKU'),
            'align' => 'left',
            'index' => 'sku',
        ));
        $this->addColumn('room_code',array(
            'header' => Mage::helper('catalog')->__('Room code'),
            'align' => 'left',
            'index' => 'room_code',
            //'filter_condition_callback' => array($this, '_filterRoomCode')
            'renderer' => 'Validoc_Floorplan_Block_Adminhtml_Floorplan_Renderer_Type'
        ));
        $this->addColumn('price', array(
            'header'=> Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width' => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        $this->addColumn('position', array(
            'header'=> Mage::helper('catalog')->__('Position'),
            'name'  => 'position',
            'width' => 60,
            'type'  => 'number',
            'validate_class'=> 'validate-number',
            'index' => 'position',
            'editable'  => true,
        ));
    }
    protected function _getSelectedProducts(){
        $products = $this->getFloorplanProducts();
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedProducts());
        }
        return $products;
    }
    public function getSelectedProducts() {
        $products = array();
        $selected = Mage::registry('current_floorplan')->getSelectedProducts();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition(), 'quantity' => $product->getQuantity());
        }
        return $products;
    }
    public function getRowUrl($item){
        return '#';
    }
    public function getGridUrl(){
        return $this->getUrl('*/*/productsGrid', array(
            'id'=>$this->getFloorplan()->getId()
        ));
    }
    public function getFloorplan(){
        return Mage::registry('current_floorplan');
    }
    protected function _addColumnFilterToCollection($column){
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                }
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    /*protected function _filterRoomCode($collection, $column){
        if(!$value = trim($column->getFilter()->getValue())){
            return;
        }
        $this->getCollection()->addFilterToFilter('customer.email', array('like' => '%'.$value.'%'));
    }*/
}
