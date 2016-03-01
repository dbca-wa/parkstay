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

class plugin_info_advanced_micromanage_tariff_editing_modes
	{
	function plugin_info_advanced_micromanage_tariff_editing_modes()
		{
		$this->data=array(
			"name"=>"advanced_micromanage_tariff_editing_modes",
			"version"=>(float)"3.0",
			"description"=> " Allows the property manager to use the Advanced and Micromanage tariff editing modes. These tariff editing modes offer greater flexability than the default Normal editing mode, enabling the property manager to set prices to be dependant on the number of people in a booking, the number of days in a booking or the number of rooms that have already been selected. You can create multiple tariffs for a given room type, creating intricate pricing schemes, giving you the best opportunity to mirror a property's existing charging method.",
			"lastupdate"=>"2013/10/09",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'advanced_micromanage_tariff_editing_modes',
			'change_log'=>'v2.5 Updated path to templates. v2.6 Removed references to Token functionality that is no longer used. v2.7 Removed references to Jomres URL Token function. v2.8 removed some unnecessary escaping. v2.9 a variety of changes, including template improvements and removal of an old script. v3.0 Fixed a bug where if the very last date in a micromanaged tariff was different, then the price would not get saved.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/advanced_micromanage_tariff_editing_modes.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/'
			);
		}
	}
?>