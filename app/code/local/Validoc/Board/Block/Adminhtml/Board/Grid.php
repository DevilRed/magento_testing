<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Board_Block_Adminhtml_Board_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array()) {
        parent::__construct($attributes);
        // id to grid
        $this->setId('boardGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
//        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection() {

        $collection = Mage::getModel('validoc_board/board')->getCollection();
        $collection->addFieldToSelect('board_id');
        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('type');
        $collection->addFieldToSelect('description');
        $this->setCollection($collection);
        parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('board_id', array(
            'header' => 'ID',
            'align' => 'center',
            'width' => '10%',
            'index' => 'board_id'
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('validoc_board')->__('Name'),
            'align' => 'left',
            'width' => '20%',
            'index' => 'name'
        ));

        $this->addColumn('type', array(
                'header' => Mage::helper('validoc_board')->__('Type'),
                'align' => 'left',
                'width' => '10%',
                'index' => 'type',
                'renderer' => 'Validoc_Board_Block_Adminhtml_Board_Renderer_Type'
            ));

        $this->addColumn('description', array(
            'header' => Mage::helper('validoc_board')->__('Description'),
            'align' => 'left',
            'width' => '50%',
            'index' => 'description'
        ));
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('validoc_board')->__('Action'),
                'width'     => '10%',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('validoc_board')->__('Edit'),
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
        $this->setMassactionIdField ( 'board_id' );
        $this->getMassactionBlock()->setFormFieldName( 'boards' );

        $this->getMassactionBlock ()->addItem ( 'delete', 
            array (
                'label' => Mage::helper( 'validoc_board' )->__( 'Delete' ),
                'url' => $this->getUrl( '*/*/massDelete' ),
                'confirm' => Mage::helper ( 'validoc_board' )->__( 'Are you sure?' )
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
}
