<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 12:13 PM
 */ 
class Validoc_Fabric_Model_Resource_Fabric extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('validoc_fabric/fabric', 'fabric_id');
    }

    public function getMediaGallery($object) {
        return $this->__getMediaGallery($object);
    }

    protected function __getMediaGallery($object) {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_fabric/fabric_image'))
            ->where('fabric_id = ?', $object->getId())
            ->order(array('position ASC'));

        return $this->_getReadAdapter()->fetchAll($select);
    }

    /**
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        if (!$object->getIsMassDelete()) {
            $object = $this->__loadImage($object);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Call-back function
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        if (!$object->getIsMassStatus()) {
            $this->__saveToImageTable($object);
//            $this->__saveToVideoTable($object);
        }

        return parent::_afterSave($object);
    }

    /**
     * Call-back function
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {

        return parent::_beforeDelete($object);
    }

    /**
     * Load images
     */
    private function __loadImage(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_fabric/fabric_image'))
            ->where('fabric_id = ?', $object->getId())
            ->order(array('position ASC', 'fabric_id'));

        $selectImageToFrontEnd = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_fabric/fabric_image_flag'), array('image','small_image','medium_image','thumbnail'))
            ->where('fabric_id = ?', $object->getId());

        $images['images'] = $this->_getReadAdapter()->fetchAll($select);
        $images['values'] = $this->_getReadAdapter()->fetchRow($selectImageToFrontEnd);

        $object->setData('media_gallery', $images);
        if (!empty($images['values'])) {
            $object->addData($images['values']);
        } else {
            $object->addData(array());
        }

        return $object;
    }

    /**
     * Save stores
     */
    private function __saveToImageTable(Mage_Core_Model_Abstract $object) {
        // getData images from ship controller
        if ($_imageList = $object->getData('fabric/media_gallery/images')) {
            $_imageList = Zend_Json::decode($_imageList);
            if (is_array($_imageList) and sizeof($_imageList) > 0) {
                $_imageTable = $this->getTable('validoc_fabric/fabric_image');
                $_adapter = $this->_getWriteAdapter();
                $_adapter->beginTransaction(); // begin transaction
                try {
                    $condition = $this->_getWriteAdapter()->quoteInto('fabric_id = ?', $object->getId());
                    $this->_getWriteAdapter()->delete($this->getTable('validoc_fabric/fabric_image'), $condition);

                    foreach ($_imageList as &$_item) {
                        if (isset($_item['removed']) and $_item['removed'] == '1') {
                            $_adapter->delete($_imageTable, $_adapter->quoteInto('fabric_id = ?', $_item['value_id'], 'INTEGER'));
                        } else {
                            $_data = array(
                                'label' => $_item['label'],
                                'file' => $_item['file'],
                                'position' => $_item['position'],
                                'disabled' => $_item['disabled'],
                                'fabric_id' => $object->getId()
                            );
                            $_adapter->insert($_imageTable, $_data);
                        }
                    }

                    // to save image flag eg: what images is small, thumbnail, etc
                    $condition = $this->_getWriteAdapter()->quoteInto('fabric_id = ?', $object->getId());
                    $this->_getWriteAdapter()->delete( $this->getTable('validoc_fabric/fabric_image_flag'), $condition );

                    $_imageValues = $object->getData('fabric/media_gallery/values');

                    if ( !empty($_imageValues) ) {
                        $_imageValues = Zend_Json::decode($_imageValues);
                        $_data = array(
                            'fabric_id' => $object->getId(),
                            'image' => isset( $_imageValues['image'] ) ? $_imageValues['image'] : NULL,
                            'small_image' => isset( $_imageValues['small_image'] ) ? $_imageValues['small_image'] : NULL,
                            'medium_image' => isset( $_imageValues['medium_image'] ) ? $_imageValues['medium_image'] : NULL,
                            'thumbnail' => isset( $_imageValues['thumbnail'] ) ? $_imageValues['thumbnail'] : NULL
                        );
                        $_adapter->insert($this->getTable('validoc_fabric/fabric_image_flag'), $_data);
                    }

                    $_adapter->commit(); // commit transaction
                } catch (Exception $e) {
                    $_adapter->rollBack();// rollback transaction
                    Mage::logException($e);
                }
            }
        }
    }

    private function __saveToVideoTable(Varien_Object $object)
    {
        $_videoList = $object->getData('fabric/videos');
        if (is_array($_videoList) && sizeof($_videoList) > 0) {
            $_adapter = $this->_getWriteAdapter();
            $_adapter->beginTransaction();// begin transaccion
            try{
                foreach($_videoList as $video) {
                    $model = Mage::getModel('validoc_fabric/fabric_video');
                    if (isset($video['delete']) && $video['delete']) {
                        $model->setId($video['id']);
                        $model->delete();
                    } else { // to update
                        if (isset($video['id']) && $video['id']) {
                            $model->setId($video['id']);
                        }
                        $model->setFabricId($object->getId());
                        $model->setVideoCode($video['code']);
                        $model->setVideoTitle($video['title']);
                        $model->setVideoThumbWidth($video['thumb_width']);
                        $model->setVideoThumbHeight($video['thumb_height']);
                        $model->setVideoWidth($video['width']);
                        $model->setVideoHeight($video['height']);
                        $model->setVideoHost($video['host']);

                        $model->save();
                    }
                }
                $_adapter->commit();
            } catch(Exception $e) {
                Mage::logException($e);
                $_adapter->rollBack();
            }
        }
    }

    public function getImageUrl(Varien_Object $object, $type) {
        $_imageTable = $this->getTable('validoc_fabric/fabric_image');
        $_imageTableFlag = $this->getTable('validoc_fabric/fabric_image_flag');
        try {
            $dbselect = $this->_getReadAdapter()->select();
            $dbselect->from(array('image' => $_imageTable));
            $dbselect->join(array('flag' => $_imageTableFlag), 'image.fabric_id = flag.fabric_id', array('image', 'small_image', 'medium_image', 'thumbnail'));
            $dbselect->where('image.fabric_id = ?', $object->getId());
            switch($type) {
                case 'base' : $dbselect->where('image.file = flag.image');
                    break;
                case 'small' : $dbselect->where('image.file = flag.small');
                    break;
                case 'medium' : $dbselect->where('image.file = flag.medium');
                    break;
                case 'thumbnail' : $dbselect->where('image.file = flag.thumbnail');
                    break;
            }
            $dbselect->where('disabled = ?', 0);
            $dbselect->order('position ASC');

            $_image = $this->_getReadAdapter()->fetchRow($dbselect);

            return $_image;
        } catch(Exception $e) {
            Mage::logException($e);
        }
    }
}