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

class plugin_info_nearest_properties_functions
	{
	function plugin_info_nearest_properties_functions()
		{
		$this->data=array(
			"name"=>"nearest_properties_functions",
			"version"=>(float)"0.8",
			"description"=> " A utility plugin to provide a nearest properties function.",
			"lastupdate"=>"2011/04/19",
			"min_jomres_ver"=>"5.5.3",
			"manual_link"=>'nearest_properties_functions',
			'change_log'=>'',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
	
// Example usage :
/*
		$result = jomres_find_nearest_properties_by_lat_long($current_property_details->lat,$current_property_details->long,1000, 100,"km");
		var_dump($result);exit;
*/
?>