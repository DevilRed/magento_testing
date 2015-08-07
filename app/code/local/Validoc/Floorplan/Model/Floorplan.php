<?php
class Validoc_Floorplan_Model_Floorplan extends Mage_Core_Model_Abstract{

    const ATTRIBUTE_CODE = 'floorplan_id';
    protected $_productInstance = null;

    protected function _construct(){
        $this->_init('validoc_floorplan/floorplan');
    }

    /**
     * Retrive product media config
     *
     * @return Validoc_Floorplan_Model_Floorplan_Media_Config
     */
    public function getMediaConfig(){
        return Mage::getSingleton('validoc_floorplan/floorplan_media_config');
    }

    /**
     * Retrive media gallery images
     *
     * @return Varien_Data_Collection
     */
    public function getMediaGalleryImages(){
        if( !$this->hasData('media_gallery_images') ) {
            $images = new Varien_Data_Collection();
            foreach ($this->_getResource()->getMediaGallery($this) as $image) {
                if ($image['disabled']) {
                    continue;
                }
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['id'] = isset($image['value_id']) ? $image['value_id'] : null;
                $image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
                $images->addItem(new Varien_Object($image));
            }
            $this->setData('media_gallery_images', $images);
        }

        return $this->getData('media_gallery_images');
    }

    public function getThumbnail() {
        $thumbnail = $this->getResource()->getThumbnail($this);
        if(!$this->hasData('media_images_thumbnail_floorplan') && $thumbnail) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($thumbnail['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($thumbnail['file']);
            $image = new Varien_Object($image);
            $this->setData('media_images_thumbnail_floorplan', $image);
        }

        return $this->getData('media_images_thumbnail_floorplan');
    }

    /**
     * Obtiene una lista de imagenes de la categoria segun label
     *
     * @param $label
     * @return array images
     */
    public function getImagesByLabel($label = '') {
        $mediaGallery = $this->getResource()->getMediaGalleryByLabel($this, $label);
        if(!$this->hasData('media_gallery_images_floorplan') && count($mediaGallery) > 0) {
            $images = new Varien_Data_Collection();
            foreach ($mediaGallery as $image) {
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
                $images->addItem(new Varien_Object($image));
            }
            $this->setData('media_gallery_images_floorplan', $images);
        }

        return $this->getData('media_gallery_images_floorplan');
    }

    public function getImageUrl($type = 'base') {
        $imageData = $this->getResource()->getImageUrl($this, $type);
        if(!$this->hasData('media_gallery_image_floorplan')) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($imageData['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($imageData['file']);
            $image = new Varien_Object($image);
            $this->setData('media_gallery_image_floorplan', $image);
        }

        return $this->getData('media_gallery_image_floorplan')->getUrl();
    }

    /**
     * @return Validoc_Designer_Model_Designer
     */
    public function getDesigner() {
        return Mage::getModel('validoc_designer/designer')->load($this->getDesignerId());
    }

    /**
     * Retrieve assigned category Ids
     *
     * @return array
     */
    public function getCategoryIds(){
        if (! $this->hasData('category_ids')) {
            $ids = $this->_getResource()->getCategoryIds($this);
            $this->setData('category_ids', $ids);
        }

        return (array) $this->_getData('category_ids');
    }

    /**
     * Set assigned category IDs array to product
     *
     * @param array|string $ids
     * @return Mage_Catalog_Model_Product
     */
    public function setCategoryIds($ids){
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        } elseif (!is_array($ids)) {
            Mage::throwException(Mage::helper('catalog')->__('Invalid category IDs.'));
        }
        foreach ($ids as $i => $v) {
            if (empty($v)) {
                unset($ids[$i]);
            }
        }

        $this->setData('category_ids', $ids);
        return $this;
    }

    public function getFloorplansByBoardId($boardId){
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $connection->select()
            ->from('validoc_floorplan', array('*'))
            ->where('board_id=? and is_active=1',$boardId);
        $rowsArray = $connection->fetchAll($select);
        return $rowsArray;
    }
    
    public function getFloorplansSiblings($floorplanId){
        //$floorplanId in fact is $boardId
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $connection->select()
            ->from('validoc_floorplan', array('*'))
            ->where('board_id=?',$floorplanId);
        $rowsArray = $connection->fetchAll($select);

        if(count($rowsArray)>0){
        	
	        return $rowsArray;
        }
        
        return array();
    }

    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('validoc_floorplan/floorplan_product');
        }
        return $this->_productInstance;
    }

    protected function _afterSave() {
        $this->getProductInstance()->saveFloorplanRelation($this);
        return parent::_afterSave();
    }

    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }
    
    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }
}