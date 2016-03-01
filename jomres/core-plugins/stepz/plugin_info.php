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

class plugin_info_stepz
	{
	function plugin_info_stepz()
		{
		$this->data=array(
			"name"=>"stepz",
			"version"=>(float)"3.3",
			"description"=> ' Shows an indicator bar to demonstrate to the guest where they are in the booking process. ',
			"lastupdate"=>"2014/01/13",
			"min_jomres_ver"=>"8.0.-3",
			"manual_link"=>'stepz',
			'change_log'=>'1.1 Modified headers to ensure script uses Jomres init check, not Joomla\'s old init check. v2 Changed 00012 stepz file to 6000, allowing it to be called via the jomres_asamodule module. Uninstall any version < v2 if you do not want two versions of the bar shown. v2.2 Changed paths to reflect v5 changes, so this plugin requires Jomres v5 or greater now. v2.3 updated the templates to use jquery ui themes. 2.4 updated for use in v5.6.  2.5 Improved stepz templates to include the jquery ui right arrow. 2.6 templates updated. 2.7 small template fixes and improvements. 2.8 removed a stray ampersand that had crept in. 2.9 Adjusted to work in Jr7 3.0  Templates bootstrapped. 3.1 Variety of changes to prevent var not set notices. v3.2 Improved the bootstrapped layout, looks like arrows now. v3.3 Added BS3 templates.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/stepz.png',
			'demo_url'=>''
			);
		}
	}
?>