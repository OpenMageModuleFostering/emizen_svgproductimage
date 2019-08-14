<?php
class Emizen_Svgproductimage_Model_Observer
{

			public function setFlexUploaderConfig(Varien_Event_Observer $observer)
			{
				$enable = Mage::getStoreConfig('svgproductimage/svgimage/enable',Mage::app()->getStore());
				if($enable)
				{
					$uploaderConfig = $observer->getBlock()->getUploader()->getConfig();
			        $additionalExtensions = array('*.svg');
			        $uploaderFileFilters = $uploaderConfig->getFilters();
			        $uploaderFileFilters['vector_images'] = array(
			                'label' => 'Vector Images(' . join(', ', $additionalExtensions) . ')',
			                'files' => $additionalExtensions
			        );
			        $uploaderConfig->setFilters($uploaderFileFilters);
			    }
			}
			
			
		
}
