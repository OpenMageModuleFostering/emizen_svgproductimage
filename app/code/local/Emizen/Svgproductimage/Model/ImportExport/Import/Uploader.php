<?php
class Emizen_Svgproductimage_Model_ImportExport_Import_Uploader extends Mage_ImportExport_Model_Import_Uploader
{
	protected $_allowedMimeTypes = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'svg' => 'image/svg'
    );

}
		