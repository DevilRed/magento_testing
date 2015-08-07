<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 4:55 PM
 */

class Validoc_Board_Model_Board extends Mage_Core_Model_Abstract
{

    const ATTRIBUTE_CODE = 'board_id';

    protected function _construct()
    {
        $this->_init('validoc_board/board');
    }

    /**
     * Retrive product media config
     *
     * @return Validoc_Board_Model_Board_Media_Config
     */
    public function getMediaConfig()
    {
        return Mage::getSingleton('validoc_board/board_media_config');
    }

    /**
     * Retrive media gallery images
     *
     * @return Varien_Data_Collection
     */
    public function getMediaGalleryImages()
    {
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
        if(!$this->hasData('media_images_thumbnail_board') && $thumbnail) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($thumbnail['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($thumbnail['file']);
            $image = new Varien_Object($image);
            $this->setData('media_images_thumbnail_board', $image);
        }

        return $this->getData('media_images_thumbnail_board');
    }

    /**
     * Obtiene una lista de imagenes de la categoria segun label
     *
     * @param $label
     * @return array images
     */
    public function getImagesByLabel($label = '') {
        $mediaGallery = $this->getResource()->getMediaGalleryByLabel($this, $label);
        if(!$this->hasData('media_gallery_images_board') && count($mediaGallery) > 0) {
            $images = new Varien_Data_Collection();
            foreach ($mediaGallery as $image) {
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
                $images->addItem(new Varien_Object($image));
            }
            $this->setData('media_gallery_images_board', $images);
        }

        return $this->getData('media_gallery_images_board');
    }

    public function getImageUrl($type = 'base') {
        $imageData = $this->getResource()->getImageUrl($this, $type);
        if(!$this->hasData('media_gallery_image_board')) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($imageData['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($imageData['file']);
            $image = new Varien_Object($image);
            $this->setData('media_gallery_image_board', $image);
        }

        return $this->getData('media_gallery_image_board')->getUrl();
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
    public function getCategoryIds()
    {
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
    public function setCategoryIds($ids)
    {
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

    public function getFloorplans($boardId){
        $m = Mage::getModel("validoc_floorplan/floorplan");
	/*$ans = $m->getFloorplansByBoardId($boardId);
	return $ans;*/
        $collection = $m->getCollection()
                        ->addFieldToFilter('board_id', $boardId);
        return $collection;
    }
    public function getCustomCategoriesId($boardId){
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $connection->select()
            ->from('validoc_board_category', array('category_id'))
            ->where('board_id=?',$boardId);
        $rowsArray = $connection->fetchAll($select);
        return $rowsArray;
    }
}
