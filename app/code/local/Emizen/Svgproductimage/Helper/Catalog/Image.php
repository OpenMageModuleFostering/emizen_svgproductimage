<?php
class Emizen_Svgproductimage_Helper_Catalog_Image extends Mage_Catalog_Helper_Image
{
	public function __toString()
    {
        try {
            $model = $this->_getModel();

            if ($this->getImageFile()) {
                $model->setBaseFile($this->getImageFile());
            } else {
                $model->setBaseFile($this->getProduct()->getData($model->getDestinationSubdir()));
            }

            $ext = pathinfo($this->getProduct()->getData($model->getDestinationSubdir()), PATHINFO_EXTENSION);
            $enable = Mage::getStoreConfig('svgproductimage/svgimage/enable',Mage::app()->getStore());
            if($ext == "svg" && $enable)
            {
                return $model->getUrl();
            }
                

            if ($model->isCached()) {
                return $model->getUrl();
            } else {
                if ($this->_scheduleRotate) {
                    $model->rotate($this->getAngle());
                }

                if ($this->_scheduleResize) {
                    $model->resize();
                }

                if ($this->getWatermark()) {
                    $model->setWatermark($this->getWatermark());
                }

                $url = $model->saveFile()->getUrl();
            }
        } catch (Exception $e) {
            $url = Mage::getDesign()->getSkinUrl($this->getPlaceholder());
        }
        return $url;
    }

    public function validateUploadFile($filePath) {
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $enable = Mage::getStoreConfig('svgproductimage/svgimage/enable',Mage::app()->getStore());
        if($ext == "svg" && $enable)
        {
            return ;
        }else{
         if (!getimagesize($filePath)) {
             Mage::throwException($this->__('Disallowed file type.'));
         }

         $_processor = new Varien_Image($filePath);
         return $_processor->getMimeType() !== null;
        }
    }
}
		