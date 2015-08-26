<?php
/**
 * @author      SouthernMonkeys Team <getintouch@southernmonkeys.com>
 */
class Validoc_Board_Adminhtml_BoardController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        /**
         * redirect user via 302 http redirect (the browser url changes)
         */
        $this->_redirect('*/*/list');
        // direct redirect  to URL without module/controller/action
        // $this->_redirectUrl('http://google.com');
    }

    public function listAction() {
        $this->_getSession()->setFormData(array());
        $this->_title($this->__('ATS'));
        $this->_title($this->__('Designer Board'));
        
        $this->loadLayout();
        $this->_setActiveMenu('ats');
//        $this->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'));
//        $this->_addBreadcrumb($this->__('Shipping'), $this->__('Shipping'));
        
        $this->renderLayout();
    }
    
    public function _isAllowed() {
        return Mage::getSingleton('admin/session')
                ->isAllowed('catalog/board');
    }
    
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    
    public function newAction() {
        $this->_forward('edit');
    }
    
    public function editAction() {
        $model = Mage::getModel('validoc_board/board');
        $id = $this->getRequest()->getParam('id');
        
        try {
            if ($id) {
                if ( !$model->load($id)->getId() ) {
                    Mage::throwException($this->__('No record with ID "%s" found', $id));
                }
            }
            Mage::register('current_board', $model);
            
            if ($model->getId()) {
                $pageTitle = $this->__('%s (%s)', $model->getName(), $model->getId());
            } else {
                $pageTitle = $this->__('New Designer Board');
            }
            $this->_title($this->__('Catalog'))
                    ->_title($this->__('Designer Board'))
                    ->_title($this->__($pageTitle));
            
            $this->loadLayout();
            
            $this->_setActiveMenu('validoc_board/board');
            $this->_addBreadcrumb($this->__('Catalog'), $this->__('Designer Board'));
            $this->renderLayout();
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/list');
        }
    }

    /**
     * Initialize board before saving
     */
    protected function _initBoardSave()
    {
        $board = $this->_initBoard();
        $boardData = $this->getRequest()->getPost();
        $board->addData($boardData);

        /**
         * Initialize product categories
         */
        $categoryIds = $this->getRequest()->getPost('category_ids');
        if (null !== $categoryIds) {
            if (empty($categoryIds)) {
                $categoryIds = array();
            }
            $board->setCategoryIds($categoryIds);
        }

        return $board;
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $this->_getSession()->setFormData($data);
            $model = Mage::getModel('validoc_board/board');
            
            try {
                $model = $this->_initBoardSave();
                $model->save();
                $this->_getSession()->addSuccess($this->__('Designer board was successfully saved'));
                
                $this->_getSession()->setFormData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    $params = array('id'=>$model->getId());
                    $this->_redirect('*/*/edit',$params);
                } else {
                    $this->_redirect('*/*/list');
                }
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array(
                        'id' => $model->getId()
                    ));
                } else {
                    $this->_redirect('*/*/new');
                }
            }
            return;
        }
    }
    
    public function deleteAction() {
        $model = Mage::getModel('validoc_board/board');
        $id = $this->getRequest()->getParam('id');
        
        try {
            if ($id) {
                if ( !$model->load($id)->getId() ) {
                    Mage::throwException($this->__('No record with ID "%s" found.', $id));
                }
            }
            $name = $model->getName();
            $model->delete();
            $this->_getSession()->addSuccess($this->__('"%s" | ID %d was successfully deleted', $name, $id));
            
            $this->_redirect('*/*');
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*');
        }
    }
    
    public function massDeleteAction() {
        $models = $this->getRequest()->getParam('boards');
        if (!is_array($models)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($models as $model) {
                    $model = Mage::getModel('validoc_board/board')->load($models);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($models)
                        )
                );
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function exportCsvAction() {
        $fileName = 'boards.csv';
        $content = $this->getLayout()->createBlock('validoc_board/adminhtml_board_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'boards.xml';
        $content = $this->getLayout()->createBlock('validoc_board/adminhtml_board_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }
    
//    public function massStatusAction() {
//        $shipping = $this->getRequest()->getParam('shipping');
//        if (!is_array($shipping)) {
//            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
//        } else {
//            try {
//                foreach ($shipping as $ship) {
//                    $qbanner = Mage::getSingleton('cruiseline/ship')
//                            ->load($ship)
//                            ->setStatus($this->getRequest()->getParam('status'))
//                            ->setIsMassupdate(true)
//                            ->save();
//                }
//                $this->_getSession()->addSuccess(
//                        $this->__('Total of %d record(s) were successfully updated', count($ship))
//                );
//            } catch (Exception $e) {
//                $this->_getSession()->addError($e->getMessage());
//            }
//        }
//        $this->_redirect('*/*/index');
//    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    public function uploadAction() {
        try {
            $uploader = new Mage_Core_Model_File_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                Mage::getSingleton('validoc_board/board_media_config')->getBaseTmpMediaPath()
            );

            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);
            $result['url'] = Mage::getSingleton('validoc_board/board_media_config')->getTmpMediaUrl($result['file']);
            $result['cookie'] = array(
                'name' => session_name(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain()
            );
        } catch (Exception $e) {
            $result = array(
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode());
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * Initialize product from request parameters
     *
     * @return Validoc_Board_Model_Board
     */
    protected function _initBoard()
    {
        $this->_title($this->__('ATS'))
            ->_title($this->__('Manage Designer Board'));

        $boardId  = (int) $this->getRequest()->getParam('id');
        $board    = Mage::getModel('validoc_board/board');

        $board->setData('_edit_mode', true);
        if ($boardId) {
            try {
                $board->load($boardId);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }


        Mage::register('board', $board);
        Mage::register('current_board', $board);
        return $board;
    }

    public function categoriesJsonAction()
    {
        $board = $this->_initBoard();

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('validoc_board/adminhtml_board_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    /**
     * Get categories fieldset block
     *
     */
    public function categoriesAction()
    {
        $this->_initBoard();
        $this->loadLayout();
        $this->renderLayout();
    }

    /*
     * saving the grid customization
     */
    public function savegridAction(){
        $this->_initBoard();
        $bdId = $this->getRequest()->getParam('boardid');
        $grid = $this->getRequest()->getParam('grid');
        //
        $grid = Mage::helper('core')->jsonEncode($grid);
        $data = array('serialized_grid' => $grid);
        $model = Mage::getModel('validoc_board/board')->load($bdId)->addData($data);
        try{
            $model->setId($bdId)->save();
            $jsonResponse = json_encode(array('msg' => 'Data updated successfully'));
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        }
        catch(Exception $e){
            $jsonResponse = json_encode(array('msg' => 'Sorry, we have experiencing some troubles, please, try again!'));
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        }
    }
    /*
     * reset grid customization
     */
    public function resetgridAction(){
        $this->_initBoard();
        $bdId = $this->getRequest()->getParam('boardid');
        $grid = $this->getRequest()->getParam('grid');
        $data = array('serialized_grid' => $grid);
        $model = Mage::getModel('validoc_board/board')->load($bdId)->addData($data);
        try{
            $model->setId($bdId)->save();
            $jsonResponse = json_encode(array('msg' => 'Reset grid successfully'));
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        }
        catch(Exception $e){
            $jsonResponse = json_encode(array('msg' => 'Sorry, we have experiencing some troubles, please, try again!'));
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
        }
    }
}
