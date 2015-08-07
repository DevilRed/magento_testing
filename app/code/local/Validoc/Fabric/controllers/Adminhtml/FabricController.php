<?php
/**
 * @author      SouthernMonkeys Team <getintouch@southernmonkeys.com>
 */
class Validoc_Fabric_Adminhtml_FabricController extends Mage_Adminhtml_Controller_Action {

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
        $this->_title($this->__('Catalog'));
        $this->_title($this->__('Fabric'));
        
        $this->loadLayout();
        $this->_setActiveMenu('ats');
//        $this->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'));
//        $this->_addBreadcrumb($this->__('Shipping'), $this->__('Shipping'));
        
        $this->renderLayout();
    }
    
    public function _isAllowed() {
        return Mage::getSingleton('admin/session')
                ->isAllowed('catalog/fabric');
    }
    
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    
    public function newAction() {
        $this->_forward('edit');
    }
    
    public function editAction() {
        $model = Mage::getModel('validoc_fabric/fabric');
        $id = $this->getRequest()->getParam('id');
        
        try {
            if ($id) {
                if ( !$model->load($id)->getId() ) {
                    Mage::throwException($this->__('No record with ID "%s" found', $id));
                }
            }
            Mage::register('current_fabric', $model);
            
            if ($model->getId()) {
                $pageTitle = $this->__('%s (%s)', $model->getName(), $model->getId());
            } else {
                $pageTitle = $this->__('New Fabric');
            }
            $this->_title($this->__('Catalog'))
                    ->_title($this->__('Fabric'))
                    ->_title($this->__($pageTitle));
            
            $this->loadLayout();
            
            $this->_setActiveMenu('ats');
            $this->_addBreadcrumb($this->__('Catalog'), $this->__('Fabric'));
            $this->renderLayout();
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/list');
        }
    }
    
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $this->_getSession()->setFormData($data);
            $model = Mage::getModel('validoc_fabric/fabric');
            $id = $this->getRequest()->getParam('id');
            
            try {
                if ($id) {
                    $model->load($id);
                }
                if($data['color'] != ''){
                    $data['color']=implode(",", $data['color']);
                }
                //Mage::log($data);
                $model->addData($data);
                $model->save();
                $this->_getSession()->addSuccess($this->__('fabric was successfully saved'));
                
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
        $model = Mage::getModel('validoc_fabric/fabric');
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
        $models = $this->getRequest()->getParam('fabrics');
        if (!is_array($models)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($models as $model) {
                    $model = Mage::getModel('validoc_fabric/fabric')->load($models);
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
        $fileName = 'fabrics.csv';
        $content = $this->getLayout()->createBlock('validoc_fabric/adminhtml_fabric_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'fabrics.xml';
        $content = $this->getLayout()->createBlock('validoc_fabric/adminhtml_fabric_grid')
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
                Mage::getSingleton('validoc_fabric/fabric_media_config')->getBaseTmpMediaPath()
            );

            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);
            $result['url'] = Mage::getSingleton('validoc_fabric/fabric_media_config')->getTmpMediaUrl($result['file']);
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
}
