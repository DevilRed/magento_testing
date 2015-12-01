<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */ 
class Validoc_Fabric_Model_Fabric extends Mage_Core_Model_Abstract
{
    const ATTRIBUTE_CODE = 'fabric_id';

    protected function _construct()
    {
        $this->_init('validoc_fabric/fabric');
    }

    /**
     * Retrive product media config
     *
     * @return Validoc_Board_Model_Board_Media_Config
     */
    public function getMediaConfig()
    {
        return Mage::getSingleton('validoc_fabric/fabric_media_config');
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
        if(!$this->hasData('media_images_thumbnail_fabric') && $thumbnail) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($thumbnail['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($thumbnail['file']);
            $image = new Varien_Object($image);
            $this->setData('media_images_thumbnail_fabric', $image);
        }

        return $this->getData('media_images_thumbnail_fabric');
    }

    /**
     * Obtiene una lista de imagenes de la categoria segun label
     *
     * @param $label
     * @return array images
     */
    public function getImagesByLabel($label = '') {
        $mediaGallery = $this->getResource()->getMediaGalleryByLabel($this, $label);
        if(!$this->hasData('media_gallery_images_fabric') && count($mediaGallery) > 0) {
            $images = new Varien_Data_Collection();
            foreach ($mediaGallery as $image) {
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
                $images->addItem(new Varien_Object($image));
            }
            $this->setData('media_gallery_images_fabric', $images);
        }

        return $this->getData('media_gallery_images_fabric');
    }

    public function getImageUrl($type = 'base') {
        $imageData = $this->getResource()->getImageUrl($this, $type);
        if(!$this->hasData('media_gallery_image_fabric')) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($imageData['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($imageData['file']);
            $image = new Varien_Object($image);
            $this->setData('media_gallery_image_fabric', $image);
        }

        return $this->getData('media_gallery_image_fabric')->getUrl();
    }

    /**
     * deleted images behavior
     */
    public function deleteImages($imgs){
        if(!empty($imgs)){
            $imgs = json_decode($imgs);
            foreach ($imgs as $k => $img) {
                if($img->removed){
                    $fileName = $img->file;
                    unset($imgs[$k]);
                    $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                    $whereSelect = "file = '" . $fileName . "'";
                    $write->query("delete from validoc_fabric_image where " . $whereSelect);
                }
            }

            $this->setData('fabric[media_gallery][images]', $imgs);
            return $imgs;
        }
    }
}