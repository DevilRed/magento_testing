<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 */

/**
 * @method int getDesignerId()
 * @method Validoc_Designer_Model_Designer setDesignerId(int $value)
 * @method string getName()
 * @method Validoc_Designer_Model_Designer setName(string $value)
 * @method string getBiography()
 * @method Validoc_Designer_Model_Designer setBiography(string $value)
 */
class Validoc_Designer_Model_Designer extends Mage_Core_Model_Abstract
{

    const TYPE_DESIGNER = '1';
    const TYPE_COLLABORATOR = '2';

    protected function _construct()
    {
        $this->_init('validoc_designer/designer');
    }

    /**
     * Retrive product media config
     *
     * @return Validoc_Designer_Model_Designer_Media_Config
     */
    public function getMediaConfig()
    {
        return Mage::getSingleton('validoc_designer/designer_media_config');
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
        if(!$this->hasData('media_images_thumbnail_designer') && $thumbnail) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($thumbnail['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($thumbnail['file']);
            $image = new Varien_Object($image);
            $this->setData('media_images_thumbnail_designer', $image);
        }

        return $this->getData('media_images_thumbnail_designer');
    }

    /**
     * Obtiene una lista de imagenes de la categoria segun label
     *
     * @param $label
     * @return array images
     */
    public function getImagesByLabel($label = '') {
        $mediaGallery = $this->getResource()->getMediaGalleryByLabel($this, $label);
        if(!$this->hasData('media_gallery_images_designer') && count($mediaGallery) > 0) {
            $images = new Varien_Data_Collection();
            foreach ($mediaGallery as $image) {
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
                $images->addItem(new Varien_Object($image));
            }
            $this->setData('media_gallery_images_designer', $images);
        }

        return $this->getData('media_gallery_images_designer');
    }

    public function getImageUrl($type = 'base') {
        $imageData = $this->getResource()->getImageUrl($this, $type);
        if(!$this->hasData('media_gallery_image_designer')) {
            $image['url'] = $this->getMediaConfig()->getMediaUrl($imageData['file']);
            $image['path'] = $this->getMediaConfig()->getMediaPath($imageData['file']);
            $image = new Varien_Object($image);
            $this->setData('media_gallery_image_designer', $image);
        }

        return $this->getData('media_gallery_image_designer')->getUrl();
    }
}