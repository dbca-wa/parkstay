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

class plugin_info_qr_code_lib
	{
	function plugin_info_qr_code_lib()
		{
		$this->data=array(
			"name"=>"qr_code_lib",
			"version"=>(float)"1.2",
			"description"=> "PHP Library required to build qr codes for display in Jomres.",
			"lastupdate"=>"2013/06/19",
			"min_jomres_ver"=>"6.0.0",
			"manual_link"=>'',
			'change_log'=>'v1.1 Changed the filename thats generated when the qr code is created. v1.2 This plugin will be removed soon, as the qr code library will be integrated into Jomres Core. Added a check to see if the qr code library function already exists. If this plugin is installed at that time, you will be prompted to remove this plugin\'s j00001 script (Jomres will handle that automatically for you).',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
?>