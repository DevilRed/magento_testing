<?php
class Validoc_Floorplan_Block_Adminhtml_Floorplan_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array()) {
        parent::__construct($attributes);
        $this->setId('floorplanGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
    }
    
    protected function _prepareCollection() {

        $collection = Mage::getModel('validoc_floorplan/floorplan')->getCollection();
        $collection->addFieldToSelect('floorplan_id');
        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('description');
        $this->setCollection($collection);
        parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('floorplan_id', array(
            'header' => 'ID',
            'align' => 'center',
            'width' => '10%',
            'index' => 'floorplan_id'
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('validoc_floorplan')->__('Name'),
            'align' => 'left',
            'width' => '30%',
            'index' => 'name'
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('validoc_floorplan')->__('Description'),
            'align' => 'left',
            'width' => '50%',
            'index' => 'description'
        ));
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('validoc_floorplan')->__('Action'),
                'width'     => '10%',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('validoc_floorplan')->__('Edit'),
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
        $this->setMassactionIdField ( 'floorplan_id' );
        $this->getMassactionBlock()->setFormFieldName( 'floorplans' );

        $this->getMassactionBlock ()->addItem ( 'delete', 
            array (
                'label' => Mage::helper( 'validoc_floorplan' )->__( 'Delete' ),
                'url' => $this->getUrl( '*/*/massDelete' ),
                'confirm' => Mage::helper ( 'validoc_floorplan' )->__( 'Are you sure?' )
            )
        );
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId())
        );
    }
}
