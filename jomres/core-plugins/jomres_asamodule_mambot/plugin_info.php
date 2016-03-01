<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_jomres_asamodule_mambot
	{
	function plugin_info_jomres_asamodule_mambot()
		{
		$this->data=array(
			"name"=>"jomres_asamodule_mambot",
			"version"=>(float)"1",
			"description"=> "Joomla plugin (aka mambot). Allows you to put anything that can called by asamodule in your content. Let's say that you want to include the calendar in your page's content somewhere. All you need to do is put {asamambot remoteavailability \"&id=1\"} in your Joomla article and you're away. The same could be done for the ui-calendar by putting {asamambot ui_availability_calendar \"&property_uid=1\"} in the content. Refer to each plugin's asamodule settings as described in it's description and use those same settings here, or refer to the asamodule report for ideas on how you can use this plugin/mambot. ",
			"lastupdate"=>"2012/11/27",
			"type"=>"mambot",
			"min_jomres_ver"=>"7.2.3",
			'change_log'=>'',
			'highlight'=>'Use the Jomres plugin manager to add it to your system, then use Joomla\'s Discover feature to install it. After that, use the Joomla Plugin Manager to enable the plugin. <p><i>Cannot be uninstalled via the Jomres plugin manager, you must use the Joomla Extension Manager instead.</i></p>',
			);
		}
	}
?>