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

class plugin_info_extended_maps
	{
	function plugin_info_extended_maps()
		{
		$this->data=array(
			"name"=>"extended_maps",
			"version"=>"4.4",
			"description"=> " Provides an alternative front page to Jomres. Shows a google map with points for the various published propertys. If displayed through jomres_asamodule you can add arguments in the arguments field in the format of '&ptype_ids=4,5,3' to ensure that you only include properties of a certain type. Three new params have been added to extended_maps v4.3 : show_properties, show_events, show_attractions. Example usage in url or asamodule: &show_properties=0 This will display a map only with attractions and events. &show_events=0&show_properties=0 This will display a map only with attractions. Property type specific markers can be uploaded to /jomres/core-plugins/extended_maps/markers/ptype dir and named like ptype_id.png. If a specific property type marker does not exist then a marker with a ? will be shown." , 
			"lastupdate"=>"2013/10/07",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'extended_maps',
			'change_log'=>'v4.1 Removed references to Token functionality that is no longer used. v4.2 changed how property type ids are input filtered. v4.3 Added options to enable switching on and off events and attractions. v4.4 added a clause to filter out properties whos owners have incorrectly set latitude and longitude.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/extended_maps.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&task=extended_maps'
			);
		}
		

	}
?>