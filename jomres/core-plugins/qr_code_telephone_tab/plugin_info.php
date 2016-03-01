<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2011 Vince Wooll/Woollyinwales IT
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_qr_code_telephone_tab
	{
	function plugin_info_qr_code_telephone_tab()
		{
		$this->data=array(
			"name"=>"qr_code_telephone_tab",
			"version"=>(float)"1.1",
			"description"=> "Adds a QR code to a new tab in the property details with the property's telephone number.",
			"lastupdate"=>"2013/07/17",
			"min_jomres_ver"=>"7.3.0",
			"manual_link"=>'',
			'change_log'=>'v1.1 Modified plugin so that it uses the new qr code generation feature.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&Itemid=103&task=viewproperty&property_uid=1'
			);
		}
	}
?>