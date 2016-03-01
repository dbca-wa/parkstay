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

class plugin_info_local_events
	{
	function plugin_info_local_events()
		{
		$this->data=array(
			"name"=>"local_events",
			"version"=>"2.5",
			"description"=> " Allows site admin to add local events that will be listed underneath the property details, and if the extended_maps plugin is installed, listed on the map.",
			"lastupdate"=>"2013/09/23",
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'local_events',
			'change_log'=>' 1.1  Updated to work in v4.2 1.3 updated to work in v6.-3.0 1.4 Changed plugin so that the lang file is included at trigger 00005 instead of trigger 00001, and to add the 00001 file to the obsolete file list. 1.5 updated some paths. 1.6 layout tweaks to editing pages. v1.7 updated to allow filtering of events and attractions based on a radius setting. v1.8 layout tweaks. 1.9 Updated to work with Jr7 2.0  Templates bootstrapped. 2.1 Jr7.1 specific changes v2.2 added the ability to save desecriptions against events/attractions. v2.3 Removed references to Token functionality that is no longer used. v2.4 Removed references to Jomres URL Token function. v2.5 Template tweaks to provide element IDs. ',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/local_events.png',
			'demo_url'=>''
			);
		}
		

	}
?>