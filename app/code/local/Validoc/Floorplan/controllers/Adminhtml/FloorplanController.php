<?php
class Validoc_Floorplan_Adminhtml_FloorplanController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->_redirect('*/*/list');
    }

    public function listAction() {
        $this->_getSession()->setFormData(array());
        $this->_title($this->__('ATS'));
        $this->_title($this->__('Floorplan'));
        $this->loadLayout();
        $this->_setActiveMenu('ats');
        $this->renderLayout();
    }
    
    public function _isAllowed() {
        return Mage::getSingleton('admin/session')
                ->isAllowed('catalog/floorplan');
    }
    
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    
    public function newAction() {
        $this->_forward('edit');
    }
    
    public function editAction() {
        $model = Mage::getModel('validoc_floorplan/floorplan');
        $id = $this->getRequest()->getParam('id');
        
        try {
            if ($id) {
                if ( !$model->load($id)->getId() ) {
                    Mage::throwException($this->__('No record with ID "%s" found', $id));
                }
            }
            Mage::register('current_floorplan', $model);
            
            if ($model->getId()) {
                $pageTitle = $this->__('%s (%s)', $model->getName(), $model->getId());
            } else {
                $pageTitle = $this->__('New Floorplan');
            }
            $this->_title($this->__('Catalog'))
                    ->_title($this->__('Floorplan'))
                    ->_title($this->__($pageTitle));
            
            $this->loadLayout();
            
            $this->_setActiveMenu('validoc_floorplan/floorplan');
            $this->_addBreadcrumb($this->__('Catalog'), $this->__('Floorplan'));
            $this->renderLayout();
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/list');
        }
    }

    /**
     * Initialize floorplan before saving
     */
    protected function _initFloorplanSave()
    {
        $floorplan = $this->_initFloorplan();
        $floorplanData = $this->getRequest()->getPost();
	$products = $this->getRequest()->getPost('products', -1);
	if ($products != -1) {
	    $floorplan->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
	}
	
        if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))) {
            try {
                 $uploader = new Varien_File_Uploader('image');
                 $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
                 $uploader->setAllowRenameFiles(false);
                 $uploader->setFilesDispersion(false);
                 $path = Mage::getBaseDir('media') . DS ;
                 $uploader->save($path, $_FILES['image']['name']);
                 $floorplanData['image'] = $_FILES['image']['name'];
           }catch(Exception $e) {
           }
        }
	else {       
             if(isset($floorplanData['image']['delete']) && $floorplanData['image']['delete'] == 1)
                 $floorplanData['image'] = '';
             else
                 unset($floorplanData['image']);
        }

	$floorplan->addData($floorplanData);
        return $floorplan;
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $this->_getSession()->setFormData($data);
            $model = Mage::getModel('validoc_floorplan/floorplan');
            
            try {
                $model = $this->_initFloorplanSave();
               
                $model->save();
                $this->_getSession()->addSuccess($this->__('Floorplan was successfully saved'));
                
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
        $model = Mage::getModel('validoc_floorplan/floorplan');
        $id = $this->getRequest()->getParam('id');
        
        try {
            if ($id) {
                if ( !$model->load($id)->getId() ) {
                    Mage::throwException($this->__('No record with ID "%s" found.', $id));
                }
            }
            $name = $model->getName();
            $model->delete();

	    $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	    $connection->beginTransaction();
	    $__condition = array($connection->quoteInto('floorplan_id=?', $id));
	    $ans = $connection->delete('validoc_floorplan_product', $__condition);
	    $connection->commit();
            
	    $this->_getSession()->addSuccess($this->__('"%s" | ID %d was successfully deleted', $name, $id));
            $this->_redirect('*/*');
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*');
        }
    }
    
    public function massDeleteAction() {
        $models = $this->getRequest()->getParam('floorplans');
        if (!is_array($models)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                foreach ($models as $id) {
                    $model = Mage::getModel('validoc_floorplan/floorplan')->load($id);
                    $model->delete();
		    $connection->beginTransaction();
            	    $__condition = array($connection->quoteInto('floorplan_id=?', $id));
            	    $ans = $connection->delete('validoc_floorplan_product', $__condition);
            	    $connection->commit();
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
        $fileName = 'floorplans.csv';
        $content = $this->getLayout()->createBlock('validoc_floorplan/adminhtml_floorplan_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'floorplans.xml';
        $content = $this->getLayout()->createBlock('validoc_floorplan/adminhtml_floorplan_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }
    
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
                Mage::getSingleton('validoc_floorplan/floorplan_media_config')->getBaseTmpMediaPath()
            );

            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);
            $result['url'] = Mage::getSingleton('validoc_floorplan/floorplan_media_config')->getTmpMediaUrl($result['file']);
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

    protected function _initFloorplan()
    {
        $this->_title($this->__('ATS'))
            ->_title($this->__('Manage Designer Floorplan'));

        $floorplanId  = (int) $this->getRequest()->getParam('id');
        $floorplan    = Mage::getModel('validoc_floorplan/floorplan');

        $floorplan->setData('_edit_mode', true);
        if ($floorplanId) {
            try {
                $floorplan->load($floorplanId);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }


        Mage::register('floorplan', $floorplan);
        Mage::register('current_floorplan', $floorplan);
        return $floorplan;
    }

	public function productsAction(){
    		$this->_initFloorplan(); 
    		$this->loadLayout();
    		$this->getLayout()->getBlock('floorplan.edit.tab.product')
        		->setFloorplanProducts($this->getRequest()->getPost('floorplan_products', null));
    		$this->renderLayout();
	}
	public function productsgridAction(){
		$this->_initFloorplan();
		$this->loadLayout();
		$this->getLayout()->getBlock('floorplan.edit.tab.product')
        		->setFloorplanProducts($this->getRequest()->getPost('floorplan_products', null));
		$this->renderLayout();
	}
}
