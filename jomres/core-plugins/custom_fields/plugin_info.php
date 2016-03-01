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

class plugin_info_custom_fields
	{
	function plugin_info_custom_fields()
		{
		$this->data=array(
			"name"=>"custom_fields",
			"version"=>(float)"1.7",
			"description"=> " Adds a new button to the administrator control panel which creates custom fields which are added to the booking form.",
			"lastupdate"=>"2013/09/19",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'custom_fields plugin',
			'change_log'=>' 1.1 updated for use in v5.6 1.2 updated to work with Jr7.1 1.3 Jr7.1 specific changes v1.4 Minor tweak to ensure that editing mode does not interfere with buttons. v1.5 Removed references to Token functionality that is no longer used. v1.6 Removed references to Jomres URL Token function. v1.7 A variety of changes relating to v7.4 changes to property type relationships.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/custom_fields.png',
			'demo_url'=>''
			);
		}
	}
?>