<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos Conde
 * Date: 7/18/14
 * Time: 4:55 PM
 */ 
class Validoc_Board_Model_Resource_Board extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Board to category linkage table
     *
     * @var string
     */
    protected $_boardCategoryTable;

    protected function _construct()
    {
        $this->_init('validoc_board/board', 'board_id');
    }

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();
        $this->_boardCategoryTable = $this->getTable('validoc_board/board_category');
    }

    public function getMediaGallery($object) {
        return $this->__getMediaGallery($object);
    }

    protected function __getMediaGallery($object) {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_board/board_image'))
            ->where('board_id = ?', $object->getId())
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

        $this->_saveCategories($object);

        return parent::_afterSave($object);
    }

    /**
     * Call-back function
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {

        return parent::_beforeDelete($object);
    }

    /**
     * Process product data before save
     *
     * @param Varien_Object $object
     * @return Validoc_Board_Model_Resource_Board
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        /**
         * Check if declared category ids in object data.
         */
        if ($object->hasCategoryIds()) {
            $categoryIds = Mage::getResourceSingleton('catalog/category')->verifyIds(
                $object->getCategoryIds()
            );
            $object->setCategoryIds($categoryIds);
        }

        return parent::_beforeSave($object);
    }

    /**
     * Load images
     */
    private function __loadImage(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_board/board_image'))
            ->where('board_id = ?', $object->getId())
            ->order(array('position ASC', 'board_id'));

        $selectImageToFrontEnd = $this->_getReadAdapter()->select()
            ->from($this->getTable('validoc_board/board_image_flag'), array('image','small_image','medium_image','thumbnail'))
            ->where('board_id = ?', $object->getId());

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
        if ($_imageList = $object->getData('board/media_gallery/images')) {
            $_imageList = Zend_Json::decode($_imageList);
            if (is_array($_imageList) and sizeof($_imageList) > 0) {
                $_imageTable = $this->getTable('validoc_board/board_image');
                $_adapter = $this->_getWriteAdapter();
                $_adapter->beginTransaction(); // begin transaction
                try {
                    $condition = $this->_getWriteAdapter()->quoteInto('board_id = ?', $object->getId());
                    $this->_getWriteAdapter()->delete($this->getTable('validoc_board/board_image'), $condition);

                    $removeFlags = array();
                    foreach ($_imageList as &$_item) {
                        if (isset($_item['removed']) and $_item['removed'] == '1') {
                            $_adapter->delete($_imageTable, $_adapter->quoteInto('board_id = ?', $_item['value_id'], 'INTEGER'));
                            $removeFlags[] = $_item['file'];
                        } else {
                            $_data = array(
                                'label' => $_item['label'],
                                'file' => $_item['file'],
                                'position' => $_item['position'],
                                'disabled' => $_item['disabled'],
                                'board_id' => $object->getId()
                            );
                            $_adapter->insert($_imageTable, $_data);
                        }
                    }

                    // to save image flag eg: what images is small, thumbnail, etc
                    $condition = $this->_getWriteAdapter()->quoteInto('board_id = ?', $object->getId());
                    $this->_getWriteAdapter()->delete( $this->getTable('validoc_board/board_image_flag'), $condition );

                    $_imageValues = $object->getData('board/media_gallery/values');

                    if ( !empty($_imageValues) ) {
                        $_imageValues = Zend_Json::decode($_imageValues);
                        $_data = array(
                            'board_id' => $object->getId(),
                            'image' => isset( $_imageValues['image'] ) && !in_array($_imageValues['image'], $removeFlags) ? $_imageValues['image'] : NULL,
                            'small_image' => isset( $_imageValues['small_image'] ) && !in_array($_imageValues['small_image'], $removeFlags) ? $_imageValues['small_image'] : NULL,
                            'medium_image' => isset( $_imageValues['medium_image'] ) && !in_array($_imageValues['medium_image'], $removeFlags) ? $_imageValues['medium_image'] : NULL,
                            'thumbnail' => isset( $_imageValues['thumbnail'] ) && !in_array($_imageValues['thumbnail'], $removeFlags) ? $_imageValues['thumbnail'] : NULL
                        );
                        $_adapter->insert($this->getTable('validoc_board/board_image_flag'), $_data);
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
        $_videoList = $object->getData('board/videos');
        if (is_array($_videoList) && sizeof($_videoList) > 0) {
            $_adapter = $this->_getWriteAdapter();
            $_adapter->beginTransaction();// begin transaccion
            try{
                foreach($_videoList as $video) {
                    $model = Mage::getModel('validoc_board/board_video');
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
        $_imageTable = $this->getTable('validoc_board/board_image');
        $_imageTableFlag = $this->getTable('validoc_board/board_image_flag');
        try {
            $dbselect = $this->_getReadAdapter()->select();
            $dbselect->from(array('image' => $_imageTable));
            $dbselect->join(array('flag' => $_imageTableFlag), 'image.board_id = flag.board_id', array('image', 'small_image', 'medium_image', 'thumbnail'));
            $dbselect->where('image.board_id = ?', $object->getId());
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

    /**
     * Save board category relations
     *
     * @param Varien_Object $object
     * @return Validoc_Board_Model_Resource_Board
     */
    protected function _saveCategories(Varien_Object $object)
    {
        /**
         * If category ids data is not declared we haven't do manipulations
         */
        if (!$object->hasCategoryIds()) {
            return $this;
        }
        $categoryIds = $object->getCategoryIds();
        $oldCategoryIds = $this->getCategoryIds($object);

        $insert = array_diff($categoryIds, $oldCategoryIds);
        $delete = array_diff($oldCategoryIds, $categoryIds);

        $write = $this->_getWriteAdapter();
        if (!empty($insert)) {
            $data = array();
            foreach ($insert as $categoryId) {
                if (empty($categoryId)) {
                    continue;
                }
                $data[] = array(
                    'category_id' => (int)$categoryId,
                    'board_id'  => (int)$object->getId(),
                    'position'    => 1
                );
            }
            if ($data) {
                $write->insertMultiple($this->_boardCategoryTable, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $categoryId) {
                $where = array(
                    'board_id = ?'  => (int)$object->getId(),
                    'category_id = ?' => (int)$categoryId,
                );

                $write->delete($this->_boardCategoryTable, $where);
            }
        }

        if (!empty($insert) || !empty($delete)) {
            $object->setAffectedCategoryIds(array_merge($insert, $delete));
        }

        return $this;
    }

    /**
     * Retrieve product category identifiers
     *
     * @param Validoc_Board_Model_Board $board
     * @return array
     */
    public function getCategoryIds($board)
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->_boardCategoryTable, 'category_id')
            ->where('board_id = ?', (int)$board->getId());

        return $adapter->fetchCol($select);
    }

    public function getMediaGalleryByLabel(Varien_Object $object, $label = '') {
        $_imageTable = $this->getTable('validoc_board/board_image');
        try {
            $dbselect = $this->_getReadAdapter()->select();
            $dbselect->where('destination_id = ?', $object->getId());
            $dbselect->where('label = ?', $label);
            $dbselect->where('disabled = ?', 0);
            $dbselect->order('position ASC');
            $dbselect->from($_imageTable);
            $_imageList = $this->_getReadAdapter()->fetchAll($dbselect);
            $rowCount = count($_imageList);

            if ($rowCount > 0) {
                return $_imageList;
            }
            return array();
        } catch(Exception $e) {
            Mage::logException($e);
            return array();
        }
    }
}