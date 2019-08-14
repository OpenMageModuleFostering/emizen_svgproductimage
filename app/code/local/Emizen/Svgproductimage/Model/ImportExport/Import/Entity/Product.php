<?php
class Emizen_Svgproductimage_Model_ImportExport_Import_Entity_Product extends Mage_ImportExport_Model_Import_Entity_Product
{
	protected function _getUploader()
    {
        if (is_null($this->_fileUploader)) {
            $this->_fileUploader    = new Emizen_Svgproductimage_Model_ImportExport_Import_Uploader();

            $this->_fileUploader->init();

            $tmpDir     = Mage::getConfig()->getOptions()->getMediaDir() . '/import';
            $destDir    = Mage::getConfig()->getOptions()->getMediaDir() . '/catalog/product';
            if (!is_writable($destDir)) {
                @mkdir($destDir, 0777, true);
            }
            if (!$this->_fileUploader->setTmpDir($tmpDir)) {
                Mage::throwException("File directory '{$tmpDir}' is not readable.");
            }
            if (!$this->_fileUploader->setDestDir($destDir)) {
                Mage::throwException("File directory '{$destDir}' is not writable.");
            }
        }
        return $this->_fileUploader;
    }
}
		