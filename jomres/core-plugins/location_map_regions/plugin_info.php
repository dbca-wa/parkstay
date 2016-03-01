<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 5
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_location_map_regions
	{
	function plugin_info_location_map_regions()
		{
		$this->data=array(
			"name"=>"location_map_regions",
			"version"=>(float)"1.2",
			"description"=> " Plugin for the location_map plugin, to run this, create a jomres_asamodule module, set the 'task' to 'location_map' and the arguments to '&mm_plugin=location_map_regions'. This will show a list of regions and towns that have been populated by published properties.",
			"lastupdate"=>"2012/08/28",
			"min_jomres_ver"=>"7.-1.0",
			"manual_link"=>'location_map_regions',
			'change_log'=>'1.1 Updated to work with Jr7 1.2  Templates bootstrapped. ',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/location_map_regions.png',
			'demo_url'=>''
			);
		}
	}
?>