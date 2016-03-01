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

class plugin_info_custom_property_fields
	{
	function plugin_info_custom_property_fields()
		{
		$this->data=array(
			"name"=>"custom_property_fields",
			"version"=>(float)"2.8",
			"description"=> " Allows you to add custom fields in the administrator area (via a new button 'custom property fields'). This allows property managers to add information extra to that normally recorded by the edit property details page. This data is added to a new tab in the property details page, however you must edit the tabcontent_01_custom_property_fields.html yourself, sample data is provided that uses the fields that you create to build the template contents.",
			"lastupdate"=>"2013/10/07",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'custom_property_fields',
			'change_log'=>'v2.1 updated to work with Jr7.1 2.2 Jr7.1 specific changes v2.3 Made changes in support of the Text Editing Mode in 7.2.6. v2.4 removed some redunant Touch Template code. v2.5 Minor tweak to ensure that editing mode does not interfere with buttons. v2.6 Removed references to Token functionality that is no longer used. v2.7 A variety of changes relating to v7.4 changes to property type relationships. v2.8 Added a condition to a bootstrap template to prevent output in the event that there is nothing to show.',
			'highlight'=>'Warning : To use this plugin you need to customise the tabcontent_01_custom_property_fields.html template file, however if you upgrade this plugin then that file will be overwritten, so please ensure that you have backed it up before upgrading this plugin.',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/custom_property_fields.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&Itemid=103&task=custom_property_field_data'
			);
		}
	}
?>