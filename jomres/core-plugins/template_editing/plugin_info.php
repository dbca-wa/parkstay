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

class plugin_info_template_editing
	{
	function plugin_info_template_editing()
		{
		$this->data=array(
			"name"=>"template_editing",
			"version"=>(float)"2.1",
			"description"=> " Adds a new button to the administrator's control panel, allowing them to edit templates via the UI and save changes to the d/b, making their template changes upgrade safe. ",
			"lastupdate"=>"2013/08/11",
			"min_jomres_ver"=>"7.2.14",
			"manual_link"=>'template_editing plugin',
			'change_log'=>'1.1 Modified javascript to make it compatible with v5.2, this plugin requires Jomres v5.2beta2 or greater. 1.2 updated for use in v5.6. 1.3 Tidied up layout to work with the 5.6 control panel changes. 1.4 updated to work with Jr7.1 1.5 Jr7.1 specific changes. v1.6 modified feature to adapt to Jomres 7.2\'s property type specific template handling. v1.7 Improved handling of css files. v1.8 tweaked script to replace some textarea output when showing the original template. If < x > is not added then the editor area will not render properly. v1.9 ensured that < x > is removed properly when saving contact owner template. v2 Added a check for Joomla 3.1 v2.1 Removed references to Token functionality that is no longer used.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/template_editing.png'
			);
		}
	}
?>