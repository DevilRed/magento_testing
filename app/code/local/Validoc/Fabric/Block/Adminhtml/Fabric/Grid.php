<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Fabric_Block_Adminhtml_Fabric_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array()) {
        parent::__construct($attributes);
        // id to grid
        $this->setId('fabricGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
//        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection() {

        $collection = Mage::getModel('validoc_fabric/fabric')->getCollection();
        $collection->addFieldToSelect('fabric_id');
        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('manufacturer');
        $collection->addFieldToSelect('color');
        $this->setCollection($collection);
        parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('fabric_id', array(
            'header' => 'ID',
            'align' => 'center',
            'width' => '10%',
            'index' => 'fabric_id'
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('validoc_fabric')->__('Name'),
            'align' => 'left',
            'width' => '30%',
            'index' => 'name'
        ));

        $this->addColumn('manufacturer', array(
            'header' => Mage::helper('validoc_fabric')->__('Source'),
            'align' => 'left',
            'width' => '30%',
            'index' => 'manufacturer',
            'renderer'  => 'Validoc_Fabric_Model_Renderer_Column_Manufacturer',
            //'filter_condition_callback' => array($this, '_manufacturerFilter'),
            'type' => 'options',
            'options' => $this->getManufacturers()
        ));
        $this->addColumn('color', array(
            'header' => Mage::helper('validoc_fabric')->__('Color'),
            'align' => 'left',
            'width' => '30%',
            'index' => 'color',
            'renderer'  => 'Validoc_Fabric_Model_Renderer_Column_Color',
            'type' => 'options',
            'options' => $this->getColors()
        ));
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('validoc_fabric')->__('Action'),
                'width'     => '10%',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('validoc_fabric')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        $this->addExportType ( '*/*/exportCsv', 'CSV' );
        $this->addExportType ( '*/*/exportXml', 'XML' );
                
        parent::_prepareColumns();
    }
    
    protected function _prepareMassaction() {
        $this->setMassactionIdField ( 'fabric_id' );
        $this->getMassactionBlock()->setFormFieldName( 'fabrics' );

        $this->getMassactionBlock ()->addItem ( 'delete', 
            array (
                'label' => Mage::helper( 'validoc_fabric' )->__( 'Delete' ),
                'url' => $this->getUrl( '*/*/massDelete' ),
                'confirm' => Mage::helper ( 'validoc_fabric' )->__( 'Are you sure?' )
            )
        );
        //
        //        $statuses = Mage::getSingleton('web/status')->getOptionArray();
        //
        //        array_unshift($statuses, array('label'=>'', 'value'=>''));
        //        $this->getMassactionBlock()->addItem('status', array(
        //             'label'=> Mage::helper('web')->__('Change status'),
        //             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
        //             'additional' => array(
        //                    'visibility' => array(
        //                         'name' => 'status',
        //                         'type' => 'select',
        //                         'class' => 'required-entry',
        //                         'label' => Mage::helper('web')->__('Status'),
        //                         'values' => $statuses
        //                     )
        //             )
        //        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId())
        );
    }
    protected function _manufacturerFilter($collection, $column){
        $filterValue = $column->getFilter()->getValue();
        if(!$filterValue){
            return $this;
        }

        $this->getCollection()->addFieldToFilter('manufacturer', array('finset' => $filterValue));
        return $this;
    }
    private function getManufacturers(){
        $manArray = array();
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('manufacturer')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false);
        foreach ($attributeOptions as $option) {
            $manArray[$option['value']] = $option['label'];
        }
        return $manArray;
    }
    private function getColors(){
        $colorsArray = array();
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter('color')->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute->getSource()->getAllOptions(false);
        foreach ($attributeOptions as $option) {
            $colorsArray[$option['value']] = $option['label'];
        }
        return $colorsArray;
    }
}
