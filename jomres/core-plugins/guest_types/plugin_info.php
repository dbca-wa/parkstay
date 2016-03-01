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

class plugin_info_guest_types
	{
	function plugin_info_guest_types()
		{
		$this->data=array(
			"name"=>"guest_types",
			"version"=>(float)"2.1",
			"description"=> " Adds a new button to the manager's toolbar which allows the administration of customer/guest types. This plugin is required if you want to charge per person per night.",
			"lastupdate"=>"2013/09/23",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'guest_types',
			'change_log'=>'1.7 Modifications to bring plugin in line with Jr7.1 for SRPs and jquery ui templates. v1.8 Made changes in support of the Text Editing Mode in 7.2.6. v1.9 Removed references to Token functionality that is no longer used. v2.0 Removed references to Jomres URL Token function. v2.1  Added code supporting new Array Caching in Jomres. ',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/guest_types.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&Itemid=103&task=listCustomerTypes'
			);
		}
	}
?>