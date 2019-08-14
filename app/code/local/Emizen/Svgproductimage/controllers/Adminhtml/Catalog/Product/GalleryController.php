<?php
require_once "Mage/Adminhtml/controllers/Catalog/Product/GalleryController.php";  
class Emizen_Svgproductimage_Adminhtml_Catalog_Product_GalleryController extends Mage_Adminhtml_Catalog_Product_GalleryController{
	public static $allowedImageExtensions = array('jpg', 'jpeg', 'gif', 'png');
    public static $allowedVectorExtensions = array('svg');
 
    /**
     * Overridden to reconfigure the Uploader
     *
     * (non-PHPdoc)
     * @see Mage_Adminhtml_Catalog_Product_GalleryController::uploadAction()
     */
    public function uploadAction()
    {
        try {
            $uploader = new Mage_Core_Model_File_Uploader('image');
 
 
            // BEGIN change
            $uploader->setAllowedExtensions($this->_getAllowedExtensions());
            $uploader->addValidateCallback('catalog_product_image', $this, 'validateUploadImage');
            $uploader->addValidateCallback('svg_image', $this, 'validateUploadVector');
            // END change
 
 
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                Mage::getSingleton('catalog/product_media_config')->getBaseTmpMediaPath()
            );
 
            Mage::dispatchEvent('catalog_product_gallery_upload_image_after', array(
                'result' => $result,
                'action' => $this
            ));
 
            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);
 
            $result['url'] = Mage::getSingleton('catalog/product_media_config')->getTmpMediaUrl($result['file']);
            $result['file'] = $result['file'] . '.tmp';
            $result['cookie'] = array(
                'name'     => session_name(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain()
            );
 
        } catch (Exception $e) {
            $result = array(
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode());
        }
 
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
 
    protected function _getAllowedExtensions()
    {
        return array_merge(self::$allowedImageExtensions, self::$allowedVectorExtensions);
    }
    public function validateUploadImage($file)
    {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), self::$allowedImageExtensions)) {
            return Mage::helper('catalog/image')->validateUploadFile($file);
        }
    }
    public function validateUploadVector($file)
    {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), self::$allowedVectorExtensions)) {
            //TODO throw exception if invalid file
            return;
        }
    }
}
				