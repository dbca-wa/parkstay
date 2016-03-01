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

class plugin_info_property_creation_plugins
	{
	function plugin_info_property_creation_plugins()
		{
		$this->data=array(
			"name"=>"property_creation_plugins",
			"version"=>(float)"3.6",
			"description"=> " Adds two new buttons to the manager's toolbar, an add property button and a delete property button. Also adds the scripts required to create a new property.",
			"lastupdate"=>"2013/09/23",
			"min_jomres_ver"=>"7.4.0",
			"manual_link"=>'property_creation_plugins',
			'change_log'=>'v3.0 Made changes in support of the Text Editing Mode in 7.2.6. v3.1 Modified the add property option in the main menu, it will now show to any registered user, not just existing managers. v3.2 Hardened an input, ensuring that it is filtered properly. v3.3 Removed references to Token functionality that is no longer used. v3.4  Removed references to Jomres URL Token function. v3.5 Added changes relating to property type relationships. v3.6 Found why some users were having problems with Token errors when installing the property creation plugin.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/property_creation_plugins.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&Itemid=103&task=registerProp_step1'
			);
		}
	}
?>