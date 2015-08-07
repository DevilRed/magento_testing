<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */
class Validoc_Atp_Block_Adminhtml_Designer_Board_Edit_Tab_Video extends Mage_Adminhtml_Block_Widget {

    protected $videosCollection = null;

    public function __construct() {
        parent::__construct();
        $this->setTemplate('cruiseline/destination/edit/tab/video.phtml');
        $this->setId('video_gallery');
        $this->setHtmlId('video_gallery');
    }

    public function getJsObjectName() {
        return $this->getHtmlId() . 'JsObject';
    }

    public function getShip() {
        return Mage::registry('current_destination');
    }

    public function getVideosCollection() {
        $storeId = (int) $this->getRequest()->getParam('store', false);

        if (is_null($this->videosCollection)) {
            $this->videosCollection = Mage::getModel('cruiseline/destination_video')
                ->getCollection()
                ->addFieldToFilter('destination_id', $this->getShip()->getId());
        }

        return $this->videosCollection;
    }
}