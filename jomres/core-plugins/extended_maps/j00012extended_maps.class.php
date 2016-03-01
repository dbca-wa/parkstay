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

class j00012extended_maps
	{
	function j00012extended_maps()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		global $task;
		$thisJRUser=jomres_getSingleton('jr_user');

		$extendedmapsettings = new jrportal_extended_maps();
		$extendedmapsettings->get_extended_maps();
		$overrideplist=$extendedmapsettings->extended_mapsConfigOptions['overrideplist'];
		
		if ($overrideplist=="1")
			{
			if ( (strlen($task)==0 && !isset($_REQUEST['plistpage']) && !isset($_REQUEST['calledByModule'])) && !$thisJRUser->userIsManager )
				{
				if (function_exists('set_showtime'))
					set_showtime('task',"extended_maps");
				$task="extended_maps";
				}
			}
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>