<?php
class Emizen_Svgproductimage_Model_Catalog_Product_Image extends Mage_Catalog_Model_Product_Image
{
	public function getUrl()
    {	
       
    	$baseDir = Mage::getBaseDir('media');
    	$enable = Mage::getStoreConfig('svgproductimage/svgimage/enable',Mage::app()->getStore());
    	$ext = pathinfo($this->_newFile, PATHINFO_EXTENSION);
        if($ext == "svg" && $enable)
        {
            $path = str_replace($baseDir . DS, "", $this->_baseFile);
        }else{
        	 $path = str_replace($baseDir . DS, "", $this->_newFile);
        }
        
        return Mage::getBaseUrl('media') . str_replace(DS, '/', $path);
    }
}
		